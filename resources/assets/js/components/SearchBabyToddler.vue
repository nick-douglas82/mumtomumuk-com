<template>
    <main class="grid-x grid-margin-x listing-filters" :class="{ 'filters-active' : showFilters }">

        <div class="cell">
            <a href="#" class="btn btn--primary filters-button" @click="toggleFilters">Filters</a>
        </div>

        <transition name="slide">
            <aside class="cell large-4" v-show="show">
                <div class="filter">
                    <div class="close__button" @click="toggleFilters">
                        <div class="close">
                            <span></span>
                            <span></span>
                        </div>
                    </div>

                    <h3 class="filter__title filter__title--main">Filter</h3>

                    <FilterTag></FilterTag>

                    <div class="view-items__wrap">
                        <a href="#" class="btn btn--primary" @click="toggleFilters">Show Results</a>
                    </div>

                </div>
            </aside>
        </transition>

        <div class="cell large-8">
            <SearchResults type="baby-toddler-groups" favtype="Listing"></SearchResults>
        </div>
    </main>
</template>

<script>
    import SearchResults from './SearchResults.vue';
    import Typeahead from './Typeahead.vue';
    import PostcodeSearch from './PostcodeSearch.vue';
    import DistanceSearch from './DistanceSearch.vue';
    import FilterTag from './FilterTag.vue';
    import moment from 'moment';
    import { Bus } from '../events';

    export default {

        components: { Typeahead, PostcodeSearch, DistanceSearch, FilterTag, SearchResults },

        data() {
            return {
                distances: [
                    { niceName: 'Within 5 miles', distance: 5, name: 'less_5', checked: '' },
                    { niceName: '10 miles', distance: 10, name: 'upto_10', checked: '' },
                    { niceName: '25 miles', distance: 25, name: 'upto_25', checked: '' },
                    { niceName: '50 miles', distance: 50, name: 'upto_50', checked: 'checked' },
                ],

                showFilters: false,

                show: ( document.body.clientWidth < 600 ) ? false : true,

                filters: [],

                postcodeSet: false
            }
        },

        mounted() {
            Bus.$on('postcodeValue', postcode => {
                this.postcodeSet = (postcode == 'empty') ? false : true;
            });
        },

        methods: {
            toggleFilters() {
                this.show = (this.show) ? false : true;
                document.documentElement.classList.toggle('filters-active');
            }
        }
    }
</script>
