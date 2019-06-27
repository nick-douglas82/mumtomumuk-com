<template>
    <div class="content__group content__group--short">
        <div class="group__title">Account Information</div>

        <div class="group__item">

            <div class="user-message error" v-for="error in errors" :key="error.id" v-html="error"></div>

            <label for="email">
                <span>Email Address</span>
                <input type="text" name=email v-model="useremail" v-on:keyup="submitEmail" @click="errors = []">
            </label>

            <div v-if="usingsocial">
                <span class="provider" v-html="provider"></span>
                <span class="note">You are currently signed in with Facebook. To change your password, please visit your Facebook account.</span>
            </div>
            <Password v-else></Password>
        </div>
    </div>
</template>

<script>
    import { Bus } from '../../../events';
    import Password from "./Password.vue";

    export default {
        components: { Password },

        props: [ 'email', 'provider', 'usingsocial' ],

        data() {
            return {
                useremail: this.email,
                timeout: 0,
                valid: true,
                errors: {}
            }
        },

        mounted() {
            Bus.$emit('email', { email: this.useremail });

            Bus.$on('formErrors', errors => {
                if ('email' in errors) {
                    this.errors = errors.email;
                }
            });
        },

        methods: {
            submitEmail() {

                clearTimeout(this.timeout);

                this.timeout = setTimeout(()=> {

                    Bus.$emit('email', { email: this.useremail });

                }, 1);
            },

        }
    }
</script>
