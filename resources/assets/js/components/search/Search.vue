<template>
    <main class="grid-x grid-margin-x listing-filters">

        <div class="cell">
            <a href="#" class="btn btn--primary filters-button">Filters</a>
        </div>

        <transition name="slide">
            <aside class="cell large-4">
                <div class="filter">
                    <div class="close__button">
                        <div class="close">
                            <span></span>
                            <span></span>
                        </div>
                    </div>

                    <h3 class="filter__title filter__title--main">Filter</h3>

                    <!-- Filters -->
                    <Filters></Filters>

                    <div class="view-items__wrap">
                        <a href="#" class="btn btn--primary">Show Results</a>
                    </div>

                </div>
            </aside>
        </transition>

        <div class="cell large-8" style="position: relative;">
            <div class="results__overlay" v-if="spinner">
                <div class="spinner"></div>
            </div>
            <!-- Renders Results -->
            <Results :results="data" :type="type" :endpoint="endpoint"></Results>
        </div>
    </main>
</template>

<script>
    import Filters from './Filters.vue';
    import Results from './Results.vue';
    import queryString from 'query-string';
    import { Bus } from '../../events';

    export default {

        components: { Filters, Results },

        props: [ 'type', 'endpoint' ],

        data () {
            return {
                spinner: false,
                data: '',
                page: '',
                queryString:'',
                filters: {
                    page: 1,
                    filters: []
                },
            }
        },

        mounted () {
            this.setPage();
            this.setQueryString();

            Bus.$on('filters', filters => {
                this.filters.filters = [...filters];

                this.spinner = true;

                this.setQueryString();
                this.fetch();
            });

            this.fetch();
        },

        methods: {
            fetch() {
                axios.get(`${ this.url() }`)
                    .then(({ data }) => {
                        this.data    = data.data;
                        this.spinner = false;
                    });
            },

            pushUrl () {
                window.history.pushState( {},"", `${ this.pageUrl() }?${ this.queryString }` );
            },

            setPage () {
                const parsed = queryString.parse(location.search);
                const page   = parseInt((parsed.page == null) ? 1 : parsed.page);

                this.filters.page = page;
                this.page         = page;
            },

            setQueryString () {

                if ( this.filters.filters.length > 0 && this.page != 1) {
                    this.filters.page = 1;
                    this.page         = 1;
                }
                this.queryString = queryString.stringify(this.filters, { arrayFormat: 'bracket' });
                this.pushUrl();
            },

            url () {
                return `${ location.pathname }/search?${ this.queryString }`
            },

            pageUrl () {
                return `${ location.origin }${ location.pathname }`;
            }
        }
    }
</script>

<style lang="scss" scoped>
.results__overlay {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background-color: rgba(255,255,255,0.7);
    z-index: 500;
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
