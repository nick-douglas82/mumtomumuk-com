<template>
    <div style="position: relative;">
        <!-- optional indicators -->
        <i class="fa fa-spinner fa-spin" v-if="loading"></i>
        <template v-else>
            <i class="fa fa-search" v-show="isEmpty"></i>
            <i class="fa fa-times" v-show="isDirty" @click="reset"></i>
        </template>

        <div class="filter__title">What are you looking for?</div>
        <!-- the input field -->
        <input type="text"
               name="disease"
               class="filter__input filter__input--search"
               placeholder="Search"
               autocomplete="off"
               v-model="query"
               @keydown.down="down"
               @keydown.up="up"
               @keydown.enter="hit"
               @keydown.esc="reset"
               @blur="softReset"
               @input="doUpdate"/>

        <ul v-show="hasItems">
            <li v-for="(item, $item) in items" v-bind:key=item.title :class="activeClass($item)" @mousedown="hit" @mousemove="setActive($item)">
                <span v-html="item.title"></span>
            </li>
        </ul>
    </div>
</template>

<script>
    import VueTypeahead from 'vue-typeahead';
    import { Bus } from '../events';

    export default {
        extends: VueTypeahead,

        data () {
            return {
                src: `${location.pathname}/search/query`,
                limit: 5,
                minChars: 3,
                showItems: true,
                query: null
            }
        },

        methods: {
            doUpdate(event) {
                this.showItems = true
                this.update()
            },

            onHit(item) {
                this.query = item.title
                Bus.$emit('searchQuery', this.query);
                this.softReset()
            },

            softReset() {
                this.loading   = false
                this.showItems = false
                this.items = []
            }
        }
    }

</script>

<style scoped>
.Typeahead {
    position: relative;
}

ul {
    position: absolute;
    padding: 0;
    min-width: 100%;
    background-color: #fff;
    list-style: none;
    z-index: 1000;
    margin-left: 0;
    border: 1px solid #95989A;
    margin-top: -2px;
    top: 86px;
}

li {
    padding: 10px 16px;
    border-bottom: 1px solid #ccc;
    cursor: pointer;
}

li:last-child {
    border-bottom: 0;
}

span {
    display: block;
    color: #2c3e50;
}
.active {
    background-color: #3aa373;
}

.active span {
    color: white;
}

.name {
    font-weight: 700;
    font-size: 18px;
}
.screen-name {
    font-style: italic;
}
</style>

