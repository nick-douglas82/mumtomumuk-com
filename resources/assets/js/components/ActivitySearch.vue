<template>
    <transition name="modal">
        <div class="modal-mask modal-mask--alt">
            <span class="modal__close" @click="modalClose">&times;</span>


            <main class="activity-search grid-container">

                <div class="grid-x grid-margin-x">

                    <div class="cell">
                        <h2 class="activity-search__title">Search the site for: <span v-html="textSearch"></span></h2>
                    </div>

                </div>

                <section class="activity-search__form grid-x grid-margin-x">
                    <div class="form__wrap form__wrap--text cell medium-6">
                        <label>Search</label>
                        <div class="wrapper">
                            <input type="text"
                                id="textSearch"
                                v-model="textSearch"
                                class="hero__input hero__search"
                                @keyup="resultRender"
                            >
                            <span class="reset" @click="reset" title="Reset Search" v-if="!inputEmpty">&times;</span>
                        </div>
                        <!-- <img src="https://www.mumtomumuk.com/images/svg/algolia-powered-by-14773f38.svg" alt="Powered by Algolia" width="100"> -->
                    </div>
                </section>

                <section class="activity-search__results">
                    <h2 class="search-results__title">Results</h2>

                    <div class="grid-x grid-margin-x activity-search__wrapper">
                        <div class="cell medium-6">

                            <Sitesearch index="after_school_clubs" :searchquery="textSearch" name="4+ clubs"></Sitesearch>

                            <Sitesearch index="baby_toddler_groups" :searchquery="textSearch" name="Baby &amp; toddler groups"></Sitesearch>

                            <Sitesearch index="directories" :searchquery="textSearch" name="Services"></Sitesearch>

                            <Sitesearch index="events" :searchquery="textSearch" name="Events"></Sitesearch>

                            <Sitesearch index="places" :searchquery="textSearch" name="Places"></Sitesearch>

                        </div>

                        <div class="cell medium-6">

                            <Sitesearch index="posts" :searchquery="textSearch" name="Posts"></Sitesearch>

                            <Sitesearch index="rebecca_reviews" :searchquery="textSearch" name="Rebecca Reviews"></Sitesearch>

                            <Sitesearch index="holiday_ideas" :searchquery="textSearch" name="Holiday Ideas"></Sitesearch>

                            <Sitesearchaskmum index="ask_mums" :searchquery="textSearch" name="Ask Mum Questions"></Sitesearchaskmum>

                        </div>

                    </div>
                </section>

            </main>

        </div>
    </transition>
</template>

<script>

    import debounce from '../debounce.js'
    import Track from '../tracking.js';

    export default {
        props: ['searchterm'],

        data() {
            return {
                timeout: '',
                textSearch: this.searchterm,
                inputEmpty: false
            }
        },


        watch: {
            textSearch: debounce(function (newVal) {
                ( newVal != '' ) ? Track.searchTerm('activity-search[overlay]', newVal, location.href) : null;
            }, 800)
        },

        created () {
            Track.searchTerm('activity-search', this.textSearch, location.href);
            this.hideUnneededPagination();
        },

        methods: {

            reset () {
                this.textSearch = '';
                this.inputEmpty = true;

                document.getElementById("textSearch").focus();
                this.hideUnneededPagination();
            },

            resultRender () {
                this.inputEmpty = false;

                clearTimeout(timeout);

                let timeout = setTimeout(() => {
                    this.hideUnneededPagination();
                }, 700);
            },

            modalClose () {
                this.textSearch = '';
                this.dateActual = null;
                this.$emit("closeModal");
            },

            hideUnneededPagination () {
                setTimeout(() => {
                    document.querySelectorAll('.ais-pagination').forEach(element => {
                        ( element.childElementCount <= 5 ) ? element.classList.add("hide") : element.classList.remove("hide");
                    });
                }, 500);
            }
        }
    }
</script>
