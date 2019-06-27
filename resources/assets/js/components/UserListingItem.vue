<template>
    <div class="group__item">
        <div class="item__title">
            <slot name="header"></slot>
            <slot></slot>
        </div>
        <ul class="action__list">
            <li class="action__item">
                <a href="#" @click.prevent="destroy()">Remove <span>&times;</span></a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {

        props: ['slug', 'type'],

        methods: {
            destroy() {
                axios.delete(`${location.origin}/${window.App.site}/favourite/${this.type}/${this.slug}`).then(this.refresh);
            },

            refresh() {
                location.reload();
            }
        }
    }
</script>
