<template>
    <div class="calendar__changer">
        <a :href="prevUrl()"><</a>
        <span>Week</span>
        <a :href="nextUrl()">></a>

        <a :href="thisWeek()">Current Week</a>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {

        components: { moment },

        props: [ 'selectedWeek' ],

        mounted() {
        },

        data() {
            return {
                currentWeek: false
            }
        },

        methods: {
            prevUrl() {
                return `${this.setUrl()}${this.setLastWeek()}`;
            },

            nextUrl() {
                return `${this.setUrl()}${this.setNextWeek()}`;
            },

            thisWeek() {
                return `${this.setUrl()}${this.setThisWeek()}`;
            },

            setUrl() {
                let str = location.pathname.substr(location.pathname.lastIndexOf('/') + 1);
                return location.pathname.replace( new RegExp(str), '' );
            },

            setLastWeek() {
                return moment(this.selectedWeek).subtract(1, 'weeks').startOf('isoWeek').format('YYYY-MM-DD').toString();
            },

            setNextWeek() {
                return moment(this.selectedWeek).add(1, 'weeks').startOf('isoWeek').format('YYYY-MM-DD').toString();
            },

            setThisWeek() {
                return moment().format('YYYY-MM-DD').toString();
            }
        }
    }
</script>
