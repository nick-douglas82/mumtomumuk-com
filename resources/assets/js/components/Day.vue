<template>
    <div>
        <header class="day__header" @click.stop="revealDay">
            <div class="day__title" v-html="displayDate(day.date)"></div>
        </header>

        <div class="day__time am" :class="{ active: isActive, 'is-active-time': amActive }">
            <div class="title">am<span @click.stop="revealTime('am')"></span></div>

            <ul class="calendar-events__list">
                <li class="calendar-events__item"
                    v-for="event in day.am"
                    :key="event.id"
                    :class="ageClass(event.age)">

                    <Tooltip :eventName="event"></Tooltip>
                </li>
            </ul>
        </div>

        <div class="day__time pm" :class="{ active: isActive, 'is-active-time': pmActive }">
            <div class="title">pm<span @click.stop="revealTime('pm')"></span></div>

            <ul class="calendar-events__list">
                <li class="calendar-events__item"
                    v-for="event in day.pm"
                    :key="event.id"
                    :class="ageClass(event.age)">

                    <Tooltip :eventName="event"></Tooltip>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import Tooltip from './Tooltip.vue';

    export default {
        props: [ 'day' ],

        components: { moment, Tooltip },

        data() {
            return {
                isActive: false,
                amActive: false,
                pmActive: false
            }
        },

        methods: {
            displayDate(date) {
                return `<span>${moment(date).format('ddd')}</span> ${moment(date).format('DD')}`;
            },

            ageClass(age) {
                return `is-${age}`;
            },

            revealDay() {
                if (window.innerWidth <= 600) {
                    this.isActive = (this.isActive) ? false : true;
                }
            },

            revealTime(timeOfDay) {
                if (timeOfDay == 'am') {
                    this.amActive = (this.amActive) ? false : true;
                    this.pmActive = false;
                }

                if (timeOfDay == 'pm') {
                    this.pmActive = (this.pmActive) ? false : true;
                    this.amActive = false;
                }
            }
        }
    }
</script>
