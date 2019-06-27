<template>
    <main class="grid-x grid-margin-x">
        <aside class="cell large-4">
           <div class="filter">
                <h3 class="filter__title filter__title--main">Filter</h3>

                <FilterTag></FilterTag>

            </div>
        </aside>

        <div class="cell large-8">
            <div v-if="data.length >= 1" v-for="item in data" :key="item.id" class="search-item">

                <a :href="itemUrl(item)" class="o-grid o-container">
                    <div class="search-item__image">
                        <img v-bind:src="mainimage(item.media)" :alt="item.title">
                    </div>
                    <div class="search-item__content">
                        <h2 class="search-item__title" v-html="truncate(item.title, '60')"></h2>
                        <h3 class="search-item__location" v-if="item.event_at">{{ item.event_at | eventdate }} - {{ item.event_end | time }}</h3>
                        <h3 class="search-item__location">{{ item.town }}</h3>
                        <p v-html="truncate(item.body, '90')"></p>
                        <p v-if="item.averageRating">Avg Rating: {{ ratingdisplay(item.averageRating, item.reviews.length) }}</p>
                    </div>
                </a>

            </div>
        </div>
    </main>
</template>

<script>

    import { Bus } from '../../events';
    import collect from 'collect.js';
    import FilterTag from '../FilterTag.vue';

    export default {

        components: { FilterTag },

        data() {
            return {
                data: [],
                tags: {}
            }
        },

        mounted() {
            axios.get(`${location.pathname}/search`).then(this.refresh);


            Bus.$on('tags', tags => {
                this.tags = tags;

                let dataCollection = collect(this.data);

                // const collection = collect([1, 2, 3, 4]);

                const filtered = dataCollection.filter(function (item, key) {
                    // return item.tags.id == 122;
                    return collect(item.tags).where('id', 122);
                });

                console.log(filtered.all());

                // const filtered = dataCollection.where('id', 1864);

                // console.log(filtered.all());
            });
        },

        methods: {
            refresh({data}) {
                this.data = data;
            },




            //MIXIN???

            itemUrl(item) {
                return `${location.pathname}/${item.slug}`;
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

            truncate: function (string, value) {
                return string.substring(0, value) + '...';
            },

            ratingdisplay (rating, reviewCount) {
                if (rating == 0 && reviewCount == 0) {
                    return 'Not reviewed yet.';
                }

                return rating;
            },
        }
    }
</script>
