<template>
    <div class="hero grid-x grid-margin-x">
        <div class="hero__item hero__item--secondary hero__item--column cell small-12 medium-6">
            <h3 class="hero__title">Looking for?</h3>
            <div class="search-box">

                <input
                    type="text"
                    placeholder="Hit enter to search..."
                    v-model="searchTerm"
                    @keyup.enter="toggleModal('open')"
                    class="hero__input hero__search"
                    autocomplete="off"
                >

                <svg class="search-box__icon" xmlns="http://www.w3.org/2000/svg" viewBox="808.5 754.5 28.78 27.609"><g id="Symbol_36" data-name="Symbol 36" transform="translate(-978 90)"><ellipse id="Ellipse_1" data-name="Ellipse 1" class="cls-1" cx="10.535" cy="10.535" rx="10.535" ry="10.535" transform="translate(1787 665)"/><line id="Line_19" data-name="Line 19" class="cls-2" x2="9.03" y2="9.03" transform="translate(1805.896 682.726)"/></g></svg>
            </div>
        </div>

        <a :href="plannerUrl" class="hero__item hero__item--primary hero__item--row cell small-12 medium-6">
            <div class="hero__content">
                <h3 class="hero__title">View the week ahead</h3>
                <p>find clubs and groups in Milton Keynes</p>
            </div>

            <img src="/images/svg/calendar_main.svg" class="hero__image">
        </a>

        <ActivitySearch
            v-if="showModal"
            :searchterm="searchTerm"
            @closeModal="toggleModal('close')"
        >
        </ActivitySearch>
    </div>

</template>

<script>

    import ActivitySearch from './ActivitySearch.vue';
    import { Bus } from '../events';
    import moment from 'moment';

    export default {
        components: { ActivitySearch },

        data() {
            return {
                showModal: false,
                searchTerm: '',
            }
        },

        methods: {
            toggleModal($event) {
                this.toggleHtmlClass();
                this.activateModal();

                if ($event == 'close') {
                    this.searchTerm = '';
                }
            },

            activateModal() {
                this.showModal = (!this.showModal) ? true : false;
            },

            toggleHtmlClass() {
                let root = document.getElementsByTagName('html')[0];
                root.classList.toggle("overlay-active");
            }
        },

        computed: {

            plannerUrl() {
                return `${location.origin}/${window.App.site}/planner/${moment().format('YYYY-MM-DD')}/`;
            }
        }
    }
</script>
