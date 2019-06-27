<template>
    <div>
        <!-- optional indicators -->
        <i class="loading-spinner" v-if="loading"></i>
        <template v-else>
            <i class="fa fa-search" v-show="isEmpty"></i>
            <i class="fa fa-times" v-show="isDirty" @click="reset"></i>
        </template>

        <!-- the input field -->
        <input type="text"
               name="disease"
               class="filter__input filter__input--search"
               placeholder="Start typing to search"
               autocomplete="off"
               v-model="query"
               @keydown.down="down"
               @keydown.up="up"
               @keydown.enter="hit"
               @keydown.esc="reset"
               @blur="softReset"
               @input="doUpdate"/>

        <ul v-show="hasItems">
            <li v-for="(item, $item) in items" v-bind:key=item.name :class="activeClass($item)" @mousedown="hit" @mousemove="setActive($item)">
                <span v-text="item.name"></span>
            </li>
        </ul>
    </div>
</template>

<script>
    import VueTypeahead from 'vue-typeahead';
    import { Bus } from '../events';

    export default {
        extends: VueTypeahead,

        props: ['searchdata'],

        data () {
            return {
                src: `${location.pathname}/search/tags`,
                limit: 5,
                minChars: 3,
                showItems: true,
                query: this.searchdata
            }
        },

        watch: {
            searchdata: function(newVal, oldVal) {
                this.query = newVal;
            }
        },

        methods: {
            doUpdate(event) {
                this.showItems = true
                this.update()
            },

            onHit(item) {
                this.query = item.name
                Bus.$emit('homeSearchQuery', {name: this.query, slug: item.slug, id: item.id});
                this.softReset()
            },

            softReset() {
                this.loading   = false
                this.showItems = false
                this.items     = []
            }
        }
    }

</script>

<style scoped>
.Typeahead {
    position: relative;
}

div {
    width: 100%;
    height: 100%;
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
    top: 54px;
    left: 0;
    width: 100%;
}

li {
    padding: 10px 16px;
    border-bottom: 1px solid #ccc;
    cursor: pointer;
    text-align: left;
}

li:last-child {
    border-bottom: 0;
}

span {
    display: block;
    color: #2c3e50;
}

input {
    border: 0;
    height: 100%;
    width: 100%;
    outline: none;
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

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(229, 122, 85, 0.3);
    border-radius: 50%;
    border-top-color: #e57a55;
    animation: spin 1s ease-in-out infinite;
    position: absolute;
    top: 18px;
}

@keyframes spin {
    to { -webkit-transform: rotate(360deg); }
}
</style>

