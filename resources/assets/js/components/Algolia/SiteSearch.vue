<template>
    <ais-index
        app-id="6D0V33FN3W"
        api-key="de6e611b9f11141eedea41ae2ef733d4"
        :index-name="index"
        :query="searchquery"
    >
        <div class="results__wrapper" @click="toggleVisibility" :class="{ visible: isVisible }">
            <ul class="search-results__list">
                <li class="search-results__item search-results__item--title">

                    <ais-no-results>
                        <template slot-scope="props">
                            {{ name }} (0)
                        </template>
                    </ais-no-results>

                    <ais-stats>
                        <template slot-scope="{ totalResults }">
                            {{ name }} ({{ totalResults }})
                        </template>
                    </ais-stats>
                </li>
                <ais-results :results-per-page="10">
                    <template slot-scope="{ result }">
                        <li class="search-results__item">
                            <a :href="postUrl(result.type, result.slug)">
                                <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                            </a>
                        </li>
                    </template>
                </ais-results>

                <ais-no-results>
                    <template slot-scope="props">
                        <li>There are no {{ name | lowercase }} found.</li>
                    </template>
                </ais-no-results>
            </ul>

            <ais-pagination v-if="moreThanOnePage" :class="index"></ais-pagination>
        </div>

    </ais-index>
</template>

<script>
    import UrlMixin from "./Mixins/UrlMixin.js";
    import FiltersMixin from "./Mixins/FiltersMixin.js";
    import VisibleMixin from "./Mixins/VisibleMixin.js";

    export default {
        props: [ 'index', 'searchquery', 'name' ],

        mixins: [ UrlMixin, FiltersMixin, VisibleMixin ],

        data () {
            return {
                moreThanOnePage: true,
                paginationClass: this.index
            }
        }
    }
</script>
