<template>
    <li class="user-nav__item">
        <a href="#" class="user-nav__link btn btn--account" @click.prevent="handle">
            Sign in <span>or</span> create an account
        </a>
    </li>
</template>

<script>
    import { Bus } from '../events';

    export default {

        data() {
            return {
                signInActive: false,
            }
        },

        mounted() {
            Bus.$on('signInActive', signInActive => {
                this.signInActive = signInActive;
            });
        },

        methods: {
            handle() {
                (this.signInActive) ? this.signInActive = false : this.signInActive = true;
                Bus.$emit('signInActive', this.signInActive);
                document.documentElement.classList.toggle('overlay-active');
            }
        }
    }
</script>
