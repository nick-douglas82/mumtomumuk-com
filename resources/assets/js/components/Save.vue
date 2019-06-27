<template>
    <button type="submit" :class="classes" @click="toggle" v-if="authCheck()">
        <i class="icon icon--star"></i>
        <div v-text="favText"></div>
    </button>
</template>

<script>
    export default {
        props: ['issaved', 'cssclasses', 'favtype', 'slug', 'title', 'endpoint'],

        data() {
            return {
                active: (this.issaved == 0 ? false : true),
                favText: ''
            }
        },

        mounted() {
            this.setText();
        },

        watch: {
            data() {
                this.$nextTick(() => {
                    this.active = (this.issaved == 0 ? false : true);
                })
            }
        },

        computed: {
            classes() {
                return [
                    this.cssclasses,
                    this.active ? 'is-favourite' : ''
                ];
            },

            url() {
                return `/${window.App.site}/favourite/${this.endpoint}/${this.slug}`;
            }
        },

        methods: {
            toggle() {
                this.active ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.url);
                this.active = true;
                this.setText();

                flash(`${this.title} has been saved to your user area.`, `${this.favtype} Saved!`);
            },

            destroy() {
                axios.delete(this.url);
                this.active = false;
                this.setText();

                flash(`${this.title} has been removed from your user area.`, `${this.favtype} Removed!`);
            },

            authCheck() {
                return window.App.signedIn;
            },

            setText() {
                if (this.active) {
                    this.favText = `${this.favtype} Saved`;
                }
                else {
                    this.favText = `Save ${this.favtype}`;
                }
            }
        }
    }
</script>
