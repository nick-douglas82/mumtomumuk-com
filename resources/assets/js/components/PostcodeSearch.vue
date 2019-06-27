<template>
    <div>
        <div class="filter__title">Where?</div>
        <input type="text" class="filter__input" placeholder="Full Postcode" v-model="postcode" @keyup="handlePostcode">
    </div>
</template>

<script>
    import { Bus } from '../events';

    export default {

        data() {
            return {
                postcode: '',
                postcodeFomatted: ''
            }
        },

        methods: {
            handlePostcode() {
                if (this.postcode == "") {
                    Bus.$emit('postcodeValue', 'empty');
                }

                if (this.postcode.length < 3) return;

                if (! this.checkPostcode()) return;

                this.postcodeFomatted = this.postcode.split(' ').join('');

                Bus.$emit('postcode', this.postcodeFomatted);
                Bus.$emit('postcodeValue', 'notempty');
            },

            checkPostcode() {
                let postcodeRegEx = /\b((?:(?:gir)|(?:[a-pr-uwyz])(?:(?:[0-9](?:[a-hjkpstuw]|[0-9])?)|(?:[a-hk-y][0-9](?:[0-9]|[abehmnprv-y])?)))) ?([0-9][abd-hjlnp-uw-z]{2})\b/ig;
                let patt = new RegExp(postcodeRegEx);
                return patt.test(this.postcode);
            }
        }
    }
</script>
