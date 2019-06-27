<template>
    <div>
        <nav class="user-filters">
            <div class="user-filters__title" @click="revealFilters" :class="{ 'active-age': isActive }">Filter Age Groups</div>

            <ul class="user-filters__list" :class="{ 'is-active-filters': isActive }">

                <li class="user-filters__item">
                    <label class="control control--checkbox">
                        <span class="user-filters-item__title">Baby</span>
                        <input type="checkbox" :checked="isChecked" value="age_baby"  @click="toggleAgeFilter('baby')" />
                        <div class="control__indicator baby"></div>
                    </label>
                </li>

                <li class="user-filters__item">
                    <label class="control control--checkbox">
                        <span class="user-filters-item__title">Toddler</span>
                        <input type="checkbox" :checked="isChecked" value="age_baby"  @click="toggleAgeFilter('toddler')" />
                        <div class="control__indicator toddler"></div>
                    </label>
                </li>

                <li class="user-filters__item">
                    <label class="control control--checkbox">
                        <span class="user-filters-item__title">All ages welcome</span>
                        <input type="checkbox" :checked="isChecked" value="age_baby"  @click="toggleAgeFilter('all')" />
                        <div class="control__indicator all"></div>
                    </label>
                </li>

                <li class="user-filters__item">
                    <label class="control control--checkbox">
                        <span class="user-filters-item__title">4+ years</span>
                        <input type="checkbox" :checked="isChecked" value="age_baby"  @click="toggleAgeFilter('4years')" />
                        <div class="control__indicator years4"></div>
                    </label>
                </li>

                <li class="user-filters__item">
                    <label class="control control--checkbox">
                        <span class="user-filters-item__title">10+ years</span>
                        <input type="checkbox" :checked="isChecked" value="age_baby"  @click="toggleAgeFilter('10years')" />
                        <div class="control__indicator years10"></div>
                    </label>
                </li>

                <li class="user-filters__item">
                    <label class="control control--checkbox">
                        <span class="user-filters-item__title">Adult</span>
                        <input type="checkbox" :checked="isChecked" value="age_baby"  @click="toggleAgeFilter('adult')" />
                        <div class="control__indicator adult"></div>
                    </label>
                </li>
            </ul>
        </nav>

        <nav class="user-filters">
            <div class="user-filters__title">Filter by Time</div>

            <ul class="user-filters__list">
                <li class="user-filters__item">
                    <label class="control control--checkbox">
                        <span class="user-filters-item__title">AM</span>
                        <input type="checkbox" :checked="isChecked" @click="toggleTimeFilter('am')" />
                        <div class="control__indicator time"></div>
                    </label>
                </li>

                <li class="user-filters__item">
                    <label class="control control--checkbox">
                        <span class="user-filters-item__title">PM</span>
                        <input type="checkbox" :checked="isChecked" @click="toggleTimeFilter('pm')" />
                        <div class="control__indicator time"></div>
                    </label>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    import { Bus } from '../events';

    export default {

        data() {
            return {
                filters: {
                    ages:['baby', 'toddler', 'all', '4years', '10years', 'adult'],
                    times:['am', 'pm']
                },
                isChecked: true,
                isActive: false
            };
        },

        mounted() {
            Bus.$emit('calendarFilters', this.filters);
        },

        methods: {
            toggleAgeFilter(filter) {
                if (this.filters.ages.includes(filter)) {
                    let index = this.filters.ages.indexOf(filter);
                    this.filters.ages.splice(index, 1);

                    Bus.$emit('calendarFilters', this.filters);
                }
                else {
                    this.filters.ages.push(filter);
                    Bus.$emit('calendarFilters', this.filters);
                }
            },

            toggleTimeFilter(filter) {
                if (this.filters.times.includes(filter)) {
                    let index = this.filters.times.indexOf(filter);
                    this.filters.times.splice(index, 1);

                    Bus.$emit('calendarFilters', this.filters);
                }
                else {
                    this.filters.times.push(filter);
                    Bus.$emit('calendarFilters', this.filters);
                }
            },

            revealFilters() {
                this.isActive = (this.isActive) ? false : true;
            },

            siteUrl() {
                return `/${window.App.site}`;
            },

            siteLinkText() {
                return `Back to ${this.capitalizeEachWord(window.App.site.replace('-', ' '))}`;
            },

            capitalizeEachWord(str) {
                return str.replace(/\w\S*/g, function(txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
            }
        }
    }
</script>
