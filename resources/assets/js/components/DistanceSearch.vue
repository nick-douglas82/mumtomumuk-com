<template>
    <div>
        <div class="filter__title">Distance</div>
        <!-- <ul class="filter__list">
            <li v-for="distance in distances" class="filter__item" :key="distance.id">
                <input type="radio"
                       v-model="selectedDistance"
                       :name="distance.name"
                       @click="distanceEvent(distance.distance)"
                >

                <label :for="distance.name">{{ distance.niceName }}</label>
            </li>
        </ul> -->

        <select class="filter__select" name="distance" v-model="defaultDistance">
            <option v-for="distance in distances" :key="distance.id"
                    :selected="distance.distance == defaultDistance"
                    :value="distance.distance"
            >
                    {{ distance.niceName }}
            </option>
        </select>

    </div>
</template>

<script>
    import { Bus } from '../events';

    export default {
        props: ['distances'],

        data() {
            return {
                selectedDistance: [],
                defaultDistance: 50
            };
        },

        watch:{
            defaultDistance (distance) {
                this.selectedDistance = distance
                Bus.$emit('distance', this.selectedDistance);
            }
        }
    }
</script>
