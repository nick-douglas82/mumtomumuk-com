<template>
    <div>
        <ul class="filter__list">
            <li v-for="tag in tags" :key="tag.index" class="filter__item">
                <label class="control control--checkbox">
                    <input type="checkbox"
                            v-model="selectedFilters"
                            :value="tag.slug">
                    <div class="control__indicator"></div>
                    <span class="user-filters-item__title" v-html="tag.name"></span>
                </label>
            </li>
        </ul>
    </div>
</template>

<script>
    import { Bus } from '../../events';
    import queryString from 'query-string';

    export default {

        data() {
            return {
                tags: '',
                selectedFilters: []
            }
        },

        mounted() {
            axios.get(`${location.pathname}/tags`)
                .then(({ data }) => {
                    this.tags = data;
                });

            if (location.search != "") {
                const parsed = queryString.parse(location.search, {arrayFormat: 'bracket'});
                this.selectedFilters = [...parsed.filters];
            }
        },

        watch: {
            selectedFilters (filters) {
                 Bus.$emit('filters', filters);
            }
        }
    }
</script>
