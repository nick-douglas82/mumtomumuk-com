<template>
    <div>
        <div v-if="data.length >= 1" v-for="item in data" :key="item.id" class="search-item">
            <a :href="itemUrl(item)" class="o-grid o-container">
                <div class="search-item__image">
                    <img v-bind:src="mainimage(item.media)" :alt="item.title">
                </div>
                <div class="search-item__content">
                    <h2 class="search-item__title" v-html="item.title"></h2>
                    <h3 class="search-item__location" v-if="item.event_at">{{ item.event_at | eventdate }} - {{ item.event_end | time }}</h3>
                    <h3 class="search-item__location">{{ item.town }}</h3>
                    <div class="body-content" v-html="truncate(item.body, '150')"></div>
                    <p v-if="item.averageRating">Avg Rating: {{ ratingdisplay(item.averageRating, item.reviews.length) }}</p>
                </div>
            </a>
            <div class="o-grid o-container">
                <div class="search-item__features">
                    <div class="search-item__tag">{{ priceTag(item) }}</div>
                    <Save :issaved="item.isFavorited"
                        :favtype="favtype"
                        :slug="item.slug"
                        :title="item.title"
                        :endpoint="type"
                        cssclasses="btn btn--primary has-icon is-square">
                    </Save>
                </div>
            </div>
        </div>

        <div v-if="data.length < 1"><p>Sorry there are no results.</p></div>

        <Paginator :dataSet="dataSet" @updated="fetch"></Paginator>

        <div class="filter__overlay" v-if="showOverlay">
            <div class="spinner"></div>
        </div>
    </div>
</template>

<script>
    import { Bus } from '../events';
    import Paginator from './Paginator.vue';
    import moment from 'moment';
    import queryString from 'query-string';

    export default {
        components: { Paginator },

        props: ['type', 'favtype'],

        data() {
            return {
                postcode: '',
                distance: null,
                data: [],
                dataSet: false,
                tags: [],
                when: [],
                date: [],
                page: 1,
                prices: [],
                params: {},
                queryTags: {},
                searchQuery: {},
                postcode: {},
                distance: {},
                showOverlay: false,
                qs: []
            }
        },

        mounted () {
            this.fetch();
            this.events();
        },

        methods: {

            dataCount () {
                return this.data.length;
            },

            fetch() {
                this.showOverlay = true;

                const parsedQs = queryString.parse(location.search, {arrayFormat: 'bracket'});
                const tags     = ( parsedQs.tags ) ? parsedQs.tags : "";
                const when     = ( parsedQs.when ) ? parsedQs.when : "";
                const date     = ( parsedQs.date ) ? parsedQs.date : "";
                const qs       = [];

                qs.page = ( parsedQs.page ) ? parsedQs.page : 1;
                this.page = ( parsedQs.page ) ? parsedQs.page : 1;

                if (tags != "") {
                    qs.tags   = tags;
                    this.tags = tags;
                }

                if (when != "") {
                    qs.when   = when;
                    this.when = when;
                }

                if (date != "") {
                    qs.date   = date;
                    this.date = date;
                }

                axios.post(`${ location.pathname }/search?${ queryString.stringify(qs, { arrayFormat: 'bracket' }) }`).then(this.refresh);
            },

            refresh({data}) {
                this.dataSet = data;
                this.data    = data.data;

                this.showOverlay = false;
            },

            itemUrl(item) {
                return `${location.pathname}/${item.slug}`;
            },

            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }

                return `${location.pathname}/search?page=${page}`;
            },

            mainimage(media) {

                let imageUrl = '';

                Object.keys(media).forEach(key => {
                    if (media[key].name === 'main_image') {
                        imageUrl = `/storage/${media[key].id}/conversions/listing.jpg`;
                    }
                });

                return imageUrl;
            },

            priceTag(item) {
                for (var i in item.tags) {
                    if (item.tags[i].type === 'priceTag') {
                        return item.tags[i].name;
                    }
                }
            },

            filter () {

                const qsArray = {
                    page: this.page,
                    tags: this.tags,
                    when: this.when,
                    date: this.date
                };
                const qsString = queryString.stringify(qsArray, { arrayFormat: 'bracket' });

                window.history.pushState( {},"", `${ location.origin }${ location.pathname }?${ qsString }` );

                this.showOverlay = true;
                axios.post(`${ location.pathname }/search?${ qsString }`).then(this.refresh);
            },

            ratingdisplay (rating, reviewCount) {
                if (rating == 0 && reviewCount == 0) {
                    return 'Not reviewed yet.';
                }

                return rating;
            },

            truncate: function (string, length) {
                let trimmedString = string.substr(0, length);

                return trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))
            },

            events() {
                Bus.$on('paginator', page => {
                    this.page = page;

                    this.filter();
                });

                Bus.$on('searchQuery', searchQuery => {
                    this.params.searchQuery = searchQuery;

                    this.filter();
                });

                Bus.$on('postcode', postcode => {
                    this.params.postcode = postcode;

                    this.filter();
                });

                Bus.$on('distance', distance => {
                    this.params.distance = distance;

                    if (this.params.postcode === undefined | this.params.postcode === null | this.params.postcode === '') return;

                    this.filter();
                });

                Bus.$on('filters', filters => {
                    this.tags = filters;

                    this.filter();
                });

                Bus.$on('when', when => {
                    this.when = when;

                    if ( when != "") {
                        this.date = [];
                        Bus.$emit('dateRefresh', this.date);
                    }

                    this.filter();
                });

                Bus.$on('date', date => {
                    this.date = (date == "") ? [] : date;

                    if (date != "") {
                        this.when = [];
                        Bus.$emit('whenRefresh', this.when);
                    }

                    this.filter();
                });

                Bus.$on('input', date => {
                    console.log('here');
                });

                Bus.$on('price', price => {
                    this.params.prices = price;

                    this.filter();
                });

                Bus.$on('time', time => {
                    this.params.time = time;

                    this.filter();
                });

                Bus.$on('day', day => {
                    this.params.day = day;

                    this.filter();
                });

                Bus.$on('rating', rating => {
                    this.params.rating = rating;

                    this.filter();
                });
            }
        },

        filters: {
            eventdate: function (date) {
                return moment(date).format('ddd, D MMM YYYY, kk:mm');
            },

            time: function (date) {
                return moment(date).format('kk:mm');
            }
        }
    }
</script>

<style lang="scss" scoped>

.body-content {
    max-height: 46px;
    overflow: hidden;
}

.filter__overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 999;
    background: rgba(255,255,255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
}

.spinner {
    display: inline-block;
    width: 50px;
    height: 50px;
    border: 3px solid rgba(#e57a55,.3);
    border-radius: 50%;
    border-top-color: #e57a55;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { -webkit-transform: rotate(360deg); }
}
</style>

