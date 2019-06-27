<template>
    <li class="planner-events__item" :data-theme="event.age" @click.prevent.stop="toggleTooltip" :class="{ 'is-active': isActive }">
        <div v-html="event.name"></div>

        <span class="tooltip" :class="{ 'is-active': isActive }">
            <div class="tooltip__title" v-html="event.name"></div>
            <div class="tooltip__times" v-html="eventTimes()"></div>
            <small class="tooltip__note">Please check opening times with organiser.</small>
            <a :href="event.event_url" target="_blank" @click.prevent.stop="goToLink" v-if="event.event_url">Link to event</a>
        </span>
    </li>
</template>

<script>
    const moment = require('moment');

    export default {
        props: [ 'event' ],

        data() {
            return {
                isActive: false
            }
        },

        methods: {

            eventTimes() {
                return `${moment(this.event.event_start).format('h:mma')} - ${moment(this.event.event_end).format('h:mma')}`;
            },

            toggleTooltip() {
                if (document.body.clientWidth < 600) {
                    this.isActive = ( this.isActive ) ? false : true;
                }
            },

            goToLink() {
                window.open(
                    this.event.event_url,
                    '_blank'
                );
            }
        }

    }
</script>
