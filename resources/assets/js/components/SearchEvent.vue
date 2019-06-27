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

                    <div class="filter__title">Filter By</div>
                    <div class="filter__wrap">

                        <div class="filter__splitter">
                            <FilterType :filters="when" eventon="when" title="When"></FilterType>

                            <div class="filter__date-pickr" style="position: relative;">
                                <flat-pickr v-model="date" placeholder="Pick a date" :config="config"></flat-pickr>
                                <span v-if="date" class="date__clear" @click.prevent="date = ''">&times;</span>
                            </div>

                        </div>

                        <FilterTag></FilterTag>

                    </div>

                    <div class="view-items__wrap">
                        <a href="#" class="btn btn--primary" @click="toggleFilters">Show Results</a>
                    </div>

                </div>
            </aside>
        </transition>

        <div class="cell large-8">
            <SearchResults type="event" favtype="Event"></SearchResults>
        </div>
    </main>
</template>

<script>
    import SearchResults from './SearchResults.vue';
    import Typeahead from './Typeahead.vue';
    import PostcodeSearch from './PostcodeSearch.vue';
    import DistanceSearch from './DistanceSearch.vue';
    import FilterTag from './FilterTag.vue';
    import FilterType from './FilterType.vue';
    import moment from 'moment';
    import { Bus } from '../events';
    import queryString from 'query-string';

    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    export default {

        components: { flatPickr, Typeahead, PostcodeSearch, DistanceSearch, FilterTag, FilterType, SearchResults },

        data() {
            return {
                distances: [
                    { niceName: 'Within 5 miles', distance: 5, name: 'less_5', checked: '' },
                    { niceName: '10 miles', distance: 10, name: 'upto_10', checked: '' },
                    { niceName: '25 miles', distance: 25, name: 'upto_25', checked: '' },
                    { niceName: '50 miles', distance: 50, name: 'upto_50', checked: 'checked' },
                ],
                filters: [],
                when: [
                    { id: 0, name: 'Today', slug: 'today', date: moment(new Date()).format('YYYY-M-D') },
                    { id: 1, name: 'Tomorrow', slug: 'tomorrow', date: moment(new Date()).add(1,'days').format('YYYY-M-D') },
                    { id: 2, name: 'This Weekend', slug: 'this-weekend', date: moment().day(6).format('YYYY-M-D') }
                ],
                date: null,
                config: {
                    wrap: false,
                    altFormat: 'j M, Y',
                    altInput: true,
                    dateFormat: "Y-m-d",
                },

                showFilters: false,

                show: ( document.body.clientWidth < 600 ) ? false : true,

                postcodeSet: false
            }
        },

        watch: {
            date() {
                Bus.$emit('date', this.date);
            }
        },

        mounted() {
            const parsedQs = queryString.parse(location.search, {arrayFormat: 'bracket'});
            const date     = ( parsedQs.date ) ? parsedQs.date : "";

            if (date != "") {
                this.date = date;
            }

            Bus.$on('dateRefresh', date => {
                this.date = [];
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

<style lang="scss" scoped>
.date__clear {
    position: absolute;
    right: 7px;
    top: -6px;
    font-size: 30px;
    display: inline;
    cursor: pointer;
}
</style>
