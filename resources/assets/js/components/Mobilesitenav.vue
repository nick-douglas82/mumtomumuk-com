<template>
    <nav class="mobile-nav" v-bind:class="{ active: isActive }">
        <header class="mobile-nav__header">
            <a :href="plannerUrl()">
                <svg xmlns="http://www.w3.org/2000/svg" class="mobile__calendar" viewBox="12945.483 -5213.542 23.727 25"><g id="Group_265" data-name="Group 265" transform="translate(12945.483 -5213.543)"><path id="Path_619" data-name="Path 619" class="cls-1" d="M6.084,952.4a.6.6,0,0,0-.608.6v5.357a.609.609,0,0,0,1.217,0V953A.6.6,0,0,0,6.084,952.4Zm11.559,0a.6.6,0,0,0-.608.6v5.357a.609.609,0,0,0,1.217,0V953A.6.6,0,0,0,17.643,952.4ZM2.434,954.781A2.415,2.415,0,0,0,0,957.162v4.167H23.727v-4.167a2.415,2.415,0,0,0-2.434-2.381H18.86v2.232a1.825,1.825,0,1,1-2.434,0v-2.232H7.3v2.232a1.825,1.825,0,1,1-2.434,0v-2.232H2.434ZM0,962.519v12.5A2.415,2.415,0,0,0,2.434,977.4H21.445a2.362,2.362,0,0,0,2.281-2.262V962.519Z" transform="translate(0 -952.4)"/></g></svg>
            </a>

            <a :href="pageUrl('users/events')" v-if="userSignedIn">
                <svg xmlns="http://www.w3.org/2000/svg" class="mobile__user" viewBox="12991.518 -5212.542 23.005 25"><g id="Group_271" data-name="Group 271" transform="translate(12759 -5245.584)"><g id="Group_264" data-name="Group 264" transform="translate(232.518 33.041)"><path id="Path_658" data-name="Path 658" class="cls-1" d="M15.592,11.385A5.692,5.692,0,1,0,9.9,5.692,5.775,5.775,0,0,0,15.592,11.385Zm0-9.038a3.345,3.345,0,1,1,0,6.69,3.307,3.307,0,0,1-3.345-3.345A3.421,3.421,0,0,1,15.592,2.347Z" transform="translate(-4.09 0)"/><path id="Path_659" data-name="Path 659" class="cls-1" d="M15.258,22.012a1.12,1.12,0,0,0-1.35.469L11.5,26.061,9.1,22.422a1.144,1.144,0,0,0-1.35-.469A11.574,11.574,0,0,0,0,32.868a1.177,1.177,0,0,0,1.174,1.174H21.831A1.177,1.177,0,0,0,23,32.868,11.443,11.443,0,0,0,15.258,22.012ZM2.406,31.695a9.28,9.28,0,0,1,5.282-7.16L10.5,28.76a1.152,1.152,0,0,0,1.937,0l2.817-4.225a9.187,9.187,0,0,1,5.282,7.16Z" transform="translate(0 -9.042)"/></g></g></svg>
            </a>

            <span class="mobile__close" @click="closeMenu()">&times;</span>
        </header>

        <ul class="mobile-nav__list o-list-bare cell">
            <li class="mobile-nav__item">
                <a :href="pageUrl('baby-toddler-groups')" class="mobile-nav__link">Baby &amp; toddler groups</a>
            </li>
            <li class="mobile-nav__item">
                <a :href="pageUrl('4-plus-activites')" class="mobile-nav__link">4+ Activites</a>
            </li>
            <li class="mobile-nav__item">
                <a :href="pageUrl('events')" class="mobile-nav__link">Events</a>
            </li>
            <li class="mobile-nav__item">
                <a :href="pageUrl('places-to-go')" class="mobile-nav__link">Places to go</a>
            </li>
            <li class="mobile-nav__item">
                <a :href="pageUrl('directory')" class="mobile-nav__link">Directory</a>
            </li>
            <li class="mobile-nav__item">
                <a :href="pageUrl('blog')" class="mobile-nav__link">Blog</a>
            </li>
            <li class="mobile-nav__item">
                <a :href="pageUrl('holiday-ideas')" class="mobile-nav__link">Holiday Ideas</a>
            </li>
            <li class="mobile-nav__item">
                <a :href="pageUrl('askmum')" class="mobile-nav__link">Askmum</a>
            </li>
            <li class="mobile-nav__item">
                <a :href="pageUrl('about-us')" class="mobile-nav__link">About</a>
            </li>
        </ul>

        <ul class="user-nav__list o-list-bare" style="display: flex; justify-content: center;" v-if="!userSignedIn">
            <Signinbutton></Signinbutton>
        </ul>

        <ul class="user-nav__list o-list-bare" style="display: flex; justify-content: center;" v-if="userSignedIn">
            <li class="user-nav__item">
                <a :href="logoutUrl()" class="user-nav__link btn btn--account">
                    Logout
                </a>
            </li>
        </ul>
    </nav>

</template>

<script>
    import moment from 'moment';
    import { Bus } from '../events';
    import Signinbutton from './SigninButton.vue';

    export default {

        component: { Signinbutton },

        data() {
            return {
                isActive: false,
                userSignedIn: false
            }
        },

        mounted() {

            if (window.App.signedIn) {
                this.userSignedIn = true;
            }

            Bus.$on('navIsActive', navIsActive => {
                this.isActive = navIsActive;
            });
        },

        methods: {
            pageUrl(page) {
                return `${location.origin}/${window.App.site}/${page}`;
            },

            plannerUrl() {
                return `${window.App.site}/planner/${moment().format('YYYY-MM-DD')}`
            },

            logoutUrl() {
                return `${location.origin}/logout`;
            },

            signedIn() {
                this.userSignedIn = ( window.App.signedIn ) ? true : false;
            },

            closeMenu() {
                this.isActive = false;
                Bus.$emit('navIsActive', this.isActive);
            }
        }
    }
</script>
