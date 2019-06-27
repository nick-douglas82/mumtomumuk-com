<template>
    <div class="grid-x grid-margin-x">

        <Postfilter :filters="tags" @filterChanged="searchFilter"></Postfilter>

        <div class="cell medium-6" v-for="post in data" :key="post.id">
            <div class="post">
                <a :href="itemUrl(post)">
                    <div class="post__image-wrap">
                        <div class="post__tag post__tag--blog">
                            <span v-html="post.category.name"></span>
                        </div>
                        <img v-bind:src="mainimage(post.media)" class="post__image" :alt="post.title">
                    </div>
                    <div class="post__content-wrap">
                        <h2 class="post__title" v-html="post.title"></h2>
                        <div class="post__content" v-html="post.snippet"></div>
                    </div>
                </a>
            </div>
        </div>

        <Paginator :dataSet="dataSet" @updated="fetch"></Paginator>

    </div>
</template>

<script>
    import Postfilter from './Postfilter.vue';
    import { Bus } from '../events';

    export default {
        components: { Postfilter },

        props: [ 'tags' ],

        data() {
            return {
                data: [],
                dataSet: false,
                page: 1
            }
        },

        mounted() {
            this.fetch();

            Bus.$on('paginator', page => {
                this.page = page;

                this.fetch();
            });
        },

        methods: {
            fetch(page) {
                axios.get(this.url(this.page)).then(this.refresh);
            },

            refresh({data}) {
                this.dataSet = data;
                this.data    = data.data;
            },

            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);

                    this.page = query ? query[1] : 1;
                }

                return `${location.pathname}/search?page=${this.page}`;
            },

            searchFilter(value) {
                axios.get(`${location.pathname}/search/category`, {
                    params: { 'category': value }
                }).then(this.refresh);
            },

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
            }
        }
    }
</script>
