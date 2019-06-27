<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li class="pagination__item" v-show="prevUrl">
            <a class="pagination__link pagination__link--prev" href="#" rel="prev" @click.prevent="page--"><i></i> Previous</a>
        </li>
        <li class="pagination__item" v-show="nextUrl">
            <a class="pagination__link pagination__link--next" href="#" rel="next" @click.prevent="page++">Next <i></i></a>
        </li>
    </ul>
</template>

<script>
    import { Bus } from '../events';

    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false,
                pageLinks: []
            }
        },

        watch: {
            dataSet() {
                this.page    = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page() {
                Bus.$emit('paginator', this.page);
            }
        },

        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl;
            },

            pagesNumber() {
                this.pageLinks = [];
                let i = 1;
                while (i <= this.dataSet.last_page) {
                    this.pageLinks.push(i);
                    i++;
                }

                return this.pageLinks;
            },

            isActived: function () {
                return this.dataSet.current_page;
            },
        },

        methods: {
            broadcast() {
                return this.$emit('updated', this.page);
            },

            updateUrl() {
                // history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>
