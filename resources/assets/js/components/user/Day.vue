<template>
    <div class="planner__day" :class="[{ 'is-active': isActive }, getDayClass()]" @click.prevent.stop="toggleActive">

        <div class="header__day" v-html="setDay()"></div>

        <div class="day__period am">
            <div class="title">am</div>

            <ul class="planner-events__list">
                <Planneritem
                    v-for="event in day.am"
                    :key="event.id"
                    :event="event">
                </Planneritem>
            </ul>

            <div class="no-results" v-if="day.am.length < 1">Sorry no results found using selected filters.</div>
        </div>

        <div class="day__period pm">
            <div class="title">pm</div>

            <ul class="planner-events__list">
                <Planneritem
                    v-for="event in day.pm"
                    :key="event.id"
                    :event="event">
                </Planneritem>
            </ul>

            <div class="no-results" v-if="day.pm.length < 1">Sorry no results found using selected filters.</div>

        </div>

    </div>
</template>

<script>
    import Planneritem from './PlannerItem.vue';
    const moment = require('moment');

    export default {
        components: { Planneritem },

        props: [ 'day' ],

        data() {
            return {
                isActive: false
            }
        },

        methods: {
            getDayClass() {
                return moment(this.day.date).format('dddd').toLowerCase();
            },

            setDay() {
                return `<span>${ moment(this.day.date).format('ddd') }</span> <span>${ moment(this.day.date).format('DD') }</span>`;
            },

            toggleActive(e) {
                e.stopPropagation();
                if (document.body.clientWidth < 600) {
                    this.isActive = ( this.isActive ) ? false : true;
                }
            }
        }
    }
</script>
