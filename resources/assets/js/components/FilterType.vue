<template>
    <div>
        <ul class="filter__list">
            <li v-for="item in filters" class="filter__item" :key="item.id">
                <label class="control control--checkbox">
                    <input type="checkbox"
                        v-model="selectedType"
                        :name="item.name"
                        :value="item.slug"
                        :for="item.slug">
                    <div class="control__indicator"></div>
                    <span class="user-filters-item__title" v-html="item.name"></span>
                </label>
            </li>
        </ul>
    </div>
</template>

<script>
    import { Bus } from '../events';
    import queryString from 'query-string';

    export default {
        props: ['filters', 'eventon', 'title'],

        data() {
            return {
                selectedType: []
            };
        },

        mounted () {
            if (location.search != "") {
                const parsed = queryString.parse(location.search, {arrayFormat: 'bracket'});
                this.selectedType = [...parsed.when];
            }

            Bus.$on('whenRefresh', when => {
                this.selectedType = (when == "") ? [] : when;
            });
        },

        watch:{
            selectedType (type) {
                Bus.$emit(`${this.eventon}`, type);
            }
        },

        filters: {
            tagGroupTitle (string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        }
    }
</script>
