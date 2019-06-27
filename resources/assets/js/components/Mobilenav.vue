<template>
    <div class="nav-trigger" @click="toggleNav" v-bind:class="{ active: navIsActive }">
        <i></i>
        <i></i>
        <i></i>
    </div>
</template>

<script>
    import { Bus } from '../events';

    export default {
        data() {
            return {
                navIsActive: false,
            }
        },

        mounted() {
            Bus.$on('navIsActive', navIsActive => {
                this.navIsActive = navIsActive;
            });
        },

        methods: {
            toggleNav() {
                (this.navIsActive) ? this.navIsActive = false : this.navIsActive = true;
                Bus.$emit('navIsActive', this.navIsActive);
            }
        }
    }
</script>
