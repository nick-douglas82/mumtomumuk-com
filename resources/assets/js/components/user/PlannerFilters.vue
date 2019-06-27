<template>
    <div>
        <nav class="user-filters" :class="{ 'is-active' : dateActive }">
            <div class="user-filters__title" @click="toggleDate">Select Date</div>

            <div class="date__wrapper">
                <datepicker
                v-model="requestedDate"
                @selected="setDate">
                </datepicker>
                <small>Please note: The calendar will automatically take you to the beginning of your selected week.</small>
            </div>
        </nav>

        <nav class="user-filters" :class="{ 'is-active' : ageActive }">
            <div class="user-filters__title" @click="toggleAge">Filter Age Groups</div>

            <ul class="user-filters__list">
                <li class="user-filters__item" v-for="filter in filters.ages" :key="filter.id">
                    <label class="control control--checkbox">
                        <span class="user-filters-item__title">{{ filter.display }}</span>
                        <input type="checkbox" v-model="pickedFilters.ages" :value="filter.name"  @click="toggleFilters(filter.name, 'age')" />
                        <div class="control__indicator" :class="filter.class"></div>
                    </label>
                </li>
            </ul>
        </nav>

        <nav class="user-filters" :class="{ 'is-active' : timeActive }">
            <div class="user-filters__title" @click="toggleTime">Filter by Time</div>

            <ul class="user-filters__list">
                <li class="user-filters__item" v-for="filter in filters.times" :key="filter.id">
                    <label class="control control--checkbox">
                        <span class="user-filters-item__title">{{ filter.display }}</span>
                        <input type="checkbox" v-model="pickedFilters.times" :value="filter.name" @click="toggleFilters(filter.name, 'time')" />
                        <div class="control__indicator" :class="filter.class"></div>
                    </label>
                </li>
            </ul>
        </nav>

        <nav class="user-filters user-filters__button">
            <a href="#" id="results-btn" class="btn btn--primary">View Results</a>
        </nav>


    </div>
</template>

<script>
    import { Bus } from '../../events';
    import Datepicker from 'vuejs-datepicker';
    const queryString = require('query-string');
    const moment = require('moment');

    export default {
        components: {
            Datepicker
        },

        data() {
            return {
                requestedDate: '',
                dateActive: false,
                ageActive: false,
                timeActive: false,
                filters: {
                    ages:[
                        { name: 'baby', display: 'Baby', class: 'baby' },
                        { name: 'toddler', display: 'Toddler', class: 'toddler' },
                        { name: 'all', display: 'All ages welcome', class: 'all' },
                        { name: '4years', display: '4+ years', class: 'years4' },
                        { name: '10years', display: '10+ years', class: 'years10' },
                        { name: 'adult', display: 'Adult', class: 'adult' }
                    ],
                    times:[
                        { name: 'am', display: 'AM', class: 'time' },
                        { name: 'pm', display: 'PM', class: 'time' },
                    ]
                },
                pickedFilters: {
                    ages:['baby', 'toddler', 'all', '4years', '10years', 'adult'],
                    times:['am', 'pm']
                },
                isChecked: true,
                url: '',
                queryString: '',
                pathArray: window.location.pathname.split( '/' )
            };
        },

        mounted() {

            this.date();

            if (location.search) {
                // Update chosen filters to match the given query string

                this.pickedFilters = queryString.parse(location.search, { arrayFormat: 'bracket' });

                if (typeof this.pickedFilters.ages === 'undefined') this.pickedFilters.ages = [];

                if (typeof this.pickedFilters.times === 'undefined') this.pickedFilters.times = [];

                this.emitFilters();

            }
            else {
                // Fire default methods to create query string from this.filters

                this.setUrl(false);
                this.emitFilters();
            }
        },

        methods: {
            date() {
                this.requestedDate = new Date(this.pathArray[3]);
            },

            setDate() {
                this.$nextTick(() => {
                    window.location = `${location.origin}/${this.pathArray[1]}/${this.pathArray[2]}/${moment(this.requestedDate).format('YYYY-MM-DD')}${location.search}`
                });
            },

            toggleDate() {
                this.dateActive = ( this.dateActive ) ? false : true;

                this.ageActive  = false;
                this.timeActive = false;
            },

            toggleTime() {
                this.timeActive = ( this.timeActive ) ? false : true;

                this.ageActive  = false;
                this.dateActive = false;
            },

            toggleAge() {
                this.ageActive  = ( this.ageActive ) ? false : true;

                this.timeActive = false;
                this.dateActive = false;
            },

            toggleFilters(name, type) {

                // if (type == 'age') {
                //     if ( !this.pickedFilters.ages.includes(name)) {
                //         this.pickedFilters.ages.push(name);
                //     }
                // }

                // if (type == 'time') {
                //     if ( !this.pickedFilters.times.includes(name)) {
                //         this.pickedFilters.times.push(name);
                //     }
                // }

                this.setUrl(true);
            },

            emitFilters() {
                Bus.$emit('plannerFilters', this.pickedFilters);
            },

            createQueryString() {
                this.queryString = queryString.stringify(this.pickedFilters, { arrayFormat: 'bracket' });
                this.url = "?" + this.queryString;

                if (location.search == "") {
                    window.history.pushState({},"", location.href + this.url);
                }
                else {
                    window.history.replaceState({}, "", this.url);
                }
            },

            createQueryStringToggle() {
                this.$nextTick(() => {
                    this.queryString = queryString.stringify(this.pickedFilters, { arrayFormat: 'bracket' });
                });

                this.$nextTick(() => {
                    this.url = "?" + this.queryString;
                });

                this.$nextTick(() => {
                    window.history.replaceState({}, "", this.url);
                });

                this.$nextTick(() => {
                    this.emitFilters();
                });
            },

            setUrl(toggle) {

                if (toggle) {
                    this.createQueryStringToggle();
                }
                else {
                    this.createQueryString();
                }
            }
        }
    }
</script>
