<template>
    <div>
        <div v-for="(filterType, key) in filters">
            <div v-for="item in items" :key="item.id"></div>
            <div class="filter__title">{{ key | tagGroupTitle }}</div>
            <ul class="filter__list">
                <li v-for="item in filterType" :key="item.id" class="filter__item">
                    <input type="checkbox"
                           v-model="selectedType"
                           :name="item.name"
                           :value="item.id"
                           :for="item.slug"
                           @click="typeEvent(item.id)"
                    >
                    <label :for="item.slug" v-html="item.name"></label>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import { Bus } from '../events';

    export default {
        props: ['filters'],

        data() {
            return {
                selectedType: []
            };
        },

        methods: {
            typeEvent (id) {
                Bus.$emit('type', id);
            }
        },

        filters: {
            tagGroupTitle (string) {
                return (string.charAt(0) == 0) ? 'Filter by' : string.charAt(0).toUpperCase() + string.slice(1);
            }
        }
    }
</script>
