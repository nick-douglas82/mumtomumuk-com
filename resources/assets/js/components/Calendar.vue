<template>
    <section class="calendar__content">
        <div class="day" v-for="day in week" :key="day.id">
            <Day :day=day></Day>
        </div>
    </section>
</template>

<script>
    import moment from 'moment';
    import CalendarWeekChanger from './CalendarWeekChanger.vue';
    import Day from './Day.vue';
    import { Bus } from '../events';

    export default {

        components: { moment, CalendarWeekChanger, Day },

        data() {
            return {
                month: '',
                currentDate: '',
                week: [],
                isActive: false,
                params: {
                    ages:['baby', 'toddler', 'all', '4years', '10years', 'adult'],
                    times:['am', 'pm']
                }
            }
        },

        mounted() {
            this.setCurrentDate();
            this.getWeeksEvents();
            this.events();
        },

        methods: {

            requestedDate() {
                return `<span>${moment(this.currentDate).format('MMMM')}</span> ${moment(this.currentDate).format('YYYY')}`;
            },

            setCurrentDate() {
                this.currentDate = location.pathname.substring(location.pathname.lastIndexOf("/") + 1);
            },

            reveal() {
                this.isShow = true;
            },

            getWeeksEvents() {

                axios.get(`${location.pathname}/search`, {
                    params: this.params
                })
                .then(({ data }) => {
                    this.week = data;
                });
            },

            events() {

                Bus.$on('calendarFilters', calendarFilters => {
                    this.params = calendarFilters;

                    this.getWeeksEvents();
                });
            }
        }
    }
</script>
