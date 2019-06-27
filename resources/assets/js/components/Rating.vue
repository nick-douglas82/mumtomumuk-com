<template>
    <div class="star-rating">
        <div class="rating__title">Rate this company</div>

        <label
            class="star-rating__star"
            v-for="rating in ratings"
            :class="{ 'is-selected' : ((value >= rating) && value != null), 'is-disabled': disabled}"
            v-on:mouseover="star_over(rating)"
            v-on:mouseout="star_out"
            v-on:click.prevent="set(rating)">
        <input ref="input" class="star-rating star-rating__checkbox" type="radio" v-bind:value="value" v-on:input="updateValue">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="3274.492 770.084 18.252 17.268"><path id="Path_553" data-name="Path 553" class="star-icon" d="M8.842,13.694l4.66,2.473a.419.419,0,0,0,.571-.38l-.951-5.231c0-.1,0-.285.1-.285l3.8-3.709c.285-.285.19-.571-.1-.666L11.6,5.134c-.1,0-.19-.1-.285-.19L8.938.189a.366.366,0,0,0-.666,0L5.894,4.944c-.1.1-.19.19-.285.19L.283,5.9a.371.371,0,0,0-.19.666L3.9,10.27a.349.349,0,0,1,.1.285l-.856,5.231a.372.372,0,0,0,.571.38C3.992,15.977,8.842,13.694,8.842,13.694Z" transform="translate(3275.048 770.609)"/></svg>
       </label>
    </div>
</template>

<script>
    export default {
        props: {
            max: '',
            disabled: '',
            default: ''
        },

        data() {
            return {
                value: 0
            }
        },

        mounted() {
            this.value = this.default;
        },

        watch: {
            value(value) {
                this.$emit('input', value);
            }
        },

        computed: {
            ratings() {
                if(!this.max) {
                    return [1, 2, 3, 4, 5];
                }

                var numberArray = [];

                for(var i = 1; this.max >= i; i++) {
                    numberArray.push(i);
                }

                return numberArray;
            }
        },

        methods: {
            updateValue(value) {
                this.$emit('input',value);
            },

            star_over(index) {
                if (this.disabled) {
                    return;
                }

                this.temp_value = this.value;
                this.value      = index;
            },

            star_out() {
                if (this.disabled) {
                    return;
                }

                this.value = this.temp_value;
            },

            set(value) {
                if (this.disabled) {
                    return;
                }

                this.temp_value = value;
                this.value      = value;

                this.$emit('rating', this.value)
            }
        }
    }
</script>
