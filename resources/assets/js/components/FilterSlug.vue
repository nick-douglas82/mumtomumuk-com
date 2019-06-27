<template>
    <div>
        <div class="filter__title">{{ title }}</div>
        <ul class="filter__list">
            <li v-for="item in filters" class="filter__item" :key="item.id">
                <input type="checkbox"
                       v-model="selectedType"
                       :name="item.name"
                       :value="item.slug"
                       :for="item.slug"
                >
                <label :for="item.slug">{{ item.name }}</label>
            </li>
        </ul>
    </div>
</template>

<script>
    import { Bus } from '../events';

    export default {
        props: ['filters', 'eventon', 'title'],

        data() {
            return {
                selectedType: []
            };
        },

        watch:{
            selectedType (type) {
                Bus.$emit(`${this.eventon}`, type);
            }
        },

        filters: {
            tagGroupTitle (string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        }
    }
</script>
