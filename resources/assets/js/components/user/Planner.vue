<template>
    <div class="planner">

        <Day v-for="day in week"
             :key="day.id"
             :day=day>
        </Day>

    </div>
</template>

<script>
    import { Bus } from '../../events';
    import Day from './Day.vue';

    export default {
        components: { Day },

        data() {
            return {
                week: '',
                params: {
                    ages:['baby', 'toddler', 'all', '4years', '10years', 'adult'],
                    times:['am', 'pm']
                }
            }
        },

        created() {
            Bus.$on('plannerFilters', plannerFilters => {
                this.params = plannerFilters;

                this.getWeeksEvents();
            });
        },

        methods: {

            getWeeksEvents() {

                axios.get(`${location.pathname}/search`, {
                    params: this.params
                })
                .then(({ data }) => {
                    this.week = data;
                });
            }
        }
    }
</script>
