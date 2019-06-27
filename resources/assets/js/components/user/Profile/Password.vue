<template>
    <div>
        <label class="nudge">
            <button class="btn btn--secondary" v-if="!show" @click="show = !show">Update Password</button>
        </label>

        <div v-if="show">

            <div class="user-message error" v-for="error in formErrors" :key="error.id" v-html="error"></div>

            <label for="current">
                <span>Enter your current password</span>
                <div class="user-message error" v-if="! currentValid">Your current password cannot be empty.</div>
                <input type="password" name="current" v-if=" ! showCurrent" v-model="passwordCurrent" v-on:keyup="submitPassword" @click="formErrors = []">
                <input type="text" name="current" v-if="showCurrent" v-model="passwordCurrent" v-on:keyup="submitPassword" @click="formErrors = []">

                <i @click="showCurrent = !showCurrent">
                    <span v-if="showCurrent" class="line"></span>
                    <svgicon icon="eye" title="Show/Hide Password"></svgicon>
                </i>
            </label>
            <label for="new">
                <span>Enter your new password</span>
                <div class="user-message error" v-if="! newValid">Your new password cannot be empty.</div>
                <input type="password" name="new" v-if=" ! showNew" v-model="passwordNew" v-on:keyup="submitPassword" @click="formErrors = []">
                <input type="text" name="new" v-if="showNew" v-model="passwordNew" v-on:keyup="submitPassword" @click="formErrors = []">

                <i @click="showNew = !showNew">
                    <span v-if="showNew" class="line"></span>
                    <svgicon icon="eye" title="Show/Hide Password"></svgicon>
                </i>
            </label>
            <label for="confirm">
                <span>Re-enter your password to confirm</span>
                <div class="user-message error" v-if="! confirmValid">You must confirm your new password.</div>
                <input type="password" name="confirm" v-if=" ! showConfirm" v-model="passwordConfirm" v-on:keyup="submitPassword" @click="formErrors = []">
                <input type="text" name="confirm" v-if="showConfirm" v-model="passwordConfirm" v-on:keyup="submitPassword" @click="formErrors = []">

                <i @click="showConfirm = !showConfirm">
                    <span v-if="showConfirm" class="line"></span>
                    <svgicon icon="eye" title="Show/Hide Password"></svgicon>
                </i>
            </label>

            <label class="nudge">
                <button class="btn btn--secondary" @click="resetPasswords">Cancel</button>
            </label>
        </div>
    </div>
</template>

<script>
    import { Bus } from '../../../events';
    import svgicon from "../../svgIcon.vue";

    export default {
        components: { svgicon },

        data() {
            return {
                show: false,
                passwordCurrent: '',
                passwordNew: '',
                passwordConfirm: '',
                showCurrent: false,
                showNew: false,
                showConfirm: false,
                timeout: null,
                passwordMatch: true,

                currentValid: true,
                newValid: true,
                confirmValid: true,
                formErrors: [],
            }
        },

        mounted() {
            this.submitPassword();

            Bus.$on('formErrors', errors => {
                this.formErrors.push(...errors.current, ...errors.password);
            });
        },

        methods: {
            validatePassword() {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(()=> {

                    this.submitPassword();

                }, 700);
            },

            submitPassword() {
                Bus.$emit('password', {
                    current: this.passwordCurrent,
                    password: this.passwordNew,
                    password_confirmation: this.passwordConfirm
                });
            },

            resetPasswords() {
                this.show = !this.show;

                this.passwordConfirm = '';
                this.passwordCurrent = '';
                this.passwordNew     = '';

                Bus.$emit('password', {
                    current: this.passwordCurrent,
                    password: this.passwordNew,
                    password_confirmation: this.passwordConfirm
                });
            }
        }
    }
</script>
