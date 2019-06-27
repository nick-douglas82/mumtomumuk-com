<template>
    <div>
        <div class="filter__title">Cost</div>
        <ul class="filter__list">
            <li v-for="price in prices" class="filter__item">
                <input type="checkbox"
                       v-model="selectedPrice"
                       :name="price.name"
                       :value="price.id"
                       :for="price.slug"
                       @click="priceEvent()"
                >

                <label :for="price.slug">{{ price.name }}</label>
            </li>
        </ul>
    </div>
</template>

<script>
    import { Bus } from '../events';

    export default {
        props: ['prices'],

        data() {
            return {
                selectedPrice: []
            };
        },

        methods: {
            priceEvent () {
                Bus.$emit('price', this.selectedPrice);
            }
        }
    }
</script>
