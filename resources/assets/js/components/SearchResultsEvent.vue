<template>
    <div>
        <div v-for="item in data" :key="item.id" class="search-item">
            <a :href="itemUrl(item)" class="o-grid o-container">
                <div class="search-item__image">
                    <img src="https://placehold.co/544x440" :alt="item.title">
                </div>
                <div class="search-item__content">
                    <h2 class="search-item__title">{{ item.title | truncate('60') }}</h2>
                    <h3 class="search-item__location">{{ item.event_at | eventdate }}</h3>
                    <h3 class="search-item__location">{{ item.town }}</h3>
                    <p>{{ item.body | truncate('90') }}</p>
                </div>
            </a>
            <div class="o-grid o-container">
                <div class="search-item__features">
                    <div class="search-item__tag">{{ priceTag(item) }}</div>
                    <Save :issaved="item.isFavorited"
                        favtype="Event"
                        :slug="item.slug"
                        endpoint="event"
                        cssclasses="btn btn--primary has-icon is-square">
                    </Save>
                </div>
            </div>
        </div>

        <Paginator :dataSet="dataSet" @updated="fetch"></Paginator>
    </div>
</template>

<script>
    import { Bus } from '../events';
    import Paginator from './Paginator.vue';
    import moment from 'moment';

    export default {
        components: { Paginator },

        data() {
            return {
                postcode: '',
                distance: null,
                data: [],
                dataSet: false,
                tags: [],
                prices: [],
                params: {}
            }
        },

        mounted() {
            this.fetch();
            this.events();
        },

        methods: {

            fetch(page) {
                axios.get(this.url(page)).then(this.refresh);
            },

            refresh({data}) {
                this.dataSet = data;
                this.data    = data.data;
            },

            itemUrl(item) {
                return `${location.pathname}/${item.slug}`;
            },

            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);
                    page      = query ? query[1] : 1;
                }

                return `${location.pathname}/search?page=${page}`;
            },

            priceTag(item) {
                for (var i in item.tags) {
                    if (item.tags[i].type === 'priceTag') {
                        return item.tags[i].name;
                    }
                }
            },

            filter() {
                axios.get(`${location.pathname}/search/`, {
                    params: this.params
                }).then(this.refresh);
            },

            events() {
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

                Bus.$on('type', type => {
                    this.params.tags = type;

                    this.filter();
                });

                Bus.$on('price', price => {
                    this.params.prices = price;

                    this.filter();
                });
            }
        },

        filters: {
            truncate: function(string, value) {
                return string.substring(0, value) + '...';
            },

            eventdate: function(date) {
                return moment(date).format('ddd, D MMM YYYY, k:m');
            }
        },

    }
</script>
