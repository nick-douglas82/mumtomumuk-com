<template>
    <div class="content__group content__group--short">
        <div class="group__title">Your Information</div>

        <div class="group__item">

            <div class="user-message error" v-for="error in errors" :key="error.id" v-html="error"></div>

            <label for="firstname">
                <span>First name</span>
                <input type="text" name=firstname v-model="fname" v-on:keyup="submitName" @click="errors = []">
            </label>

            <label for="lastname">
                <span>Last name</span>
                <input type="text" name=lastname v-model="lname" v-on:keyup="submitName" @click="errors = []">
            </label>

        </div>
    </div>
</template>

<script>
    import { Bus } from '../../../events';

    export default {
        props: [ 'firstname', 'lastname' ],

        data() {
            return {
                fname: this.firstname,
                lname: this.lastname,
                valid: true,
                timeout: 0,
                errors: {}
            }
        },

        mounted() {
            Bus.$emit('name', { name: `${ this.fname } ${ this.lname }` });

            Bus.$on('formErrors', errors => {
                if ('name' in errors) {
                    this.errors = errors.name;
                }
            });
        },

        methods: {
            submitName() {
                this.valid = true;

                clearTimeout(this.timeout);

                this.timeout = setTimeout(()=> {

                        Bus.$emit('name', { name: `${ this.fname } ${ this.lname }` });

                }, 1);
            },
        }
    }
</script>
