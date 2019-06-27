<template>
    <div>
        <div @mouseover.stop="toggleActive()" @mouseout.stop="toggleActive()" v-html="eventName.name"></div>
        <div class="info-box" v-show="isActive">
            <span class="close" @click="isActive == false">&times;</span>
            <div class="info-box__title" v-html="eventName.name"></div>
            <div class="info-box__times">{{ eventTimes(eventName.event_start, eventName.event_end) }}</div>
            <div class="info-box__address" v-html="eventAddress(eventName.address)"></div>
            <small>Please check opening times with organiser.</small>
            <small><strong>Note:</strong> Please go to the Baby and Toddler or 4+ listing page for more details.</small>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['eventName'],

        data: function() {
            return {
                isActive: false
            }
        },

        methods: {
            toggleActive() {
                (this.isActive) ? this.isActive = false : this.isActive = true;
            },

            eventAddress(address) {
                // return address.replace(', United Kingdom', '');
                return '';
            },

            eventTimes(start, end) {
                return `${moment(start).format('h:mma')} - ${moment(end).format('h:mma')}`;
            }
        }
    }
</script>

<style scoped>
small {
    font-size: 14px;
    margin-top: 10px;
    display: block;
    font-style: italic;
}
</style>
