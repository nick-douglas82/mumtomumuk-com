<template>
    <div class="filter">
        <h3 class="filter__title filter__title--main">Filter</h3>

        <Typeahead></Typeahead>

        <PostcodeSearch></PostcodeSearch>

        <DistanceSearch :distances="distances"></DistanceSearch>

        <FilterType :filters="filters"></FilterType>
    </div>
</template>

<script>
    import Typeahead from './Typeahead.vue';
    import PostcodeSearch from './PostcodeSearch.vue';
    import DistanceSearch from './DistanceSearch.vue';
    import FilterType from './FilterType.vue';


    export default {

        data() {
            return {
                distances: [
                    { niceName: 'Within 5 miles', distance: 5, name: 'less_5', checked: '' },
                    { niceName: '10 miles', distance: 10, name: 'upto_10', checked: '' },
                    { niceName: '25 miles', distance: 25, name: 'upto_25', checked: '' },
                    { niceName: '50 miles', distance: 50, name: 'upto_50', checked: 'checked' },
                ],
                filters: []
            }
        },

        components: {
            Typeahead,
            PostcodeSearch,
            DistanceSearch,
            FilterType
        },

        mounted() {
            var site = location.pathname.split("/");
            axios.get(`/${site[1]}/tags`)
                .then(({ data }) => {
                    this.filters = data;
                });
        }
    }
</script>
