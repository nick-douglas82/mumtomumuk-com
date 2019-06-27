
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./external-links');

Vue.prototype.signedIn = window.App.signedIn;
Vue.prototype.user     = window.App.user;
Vue.prototype.$http    = window.axios;

import { HasError, AlertError, AlertSuccess } from 'vform';
import VueAnalytics from 'vue-analytics'

Vue.use(VueAnalytics, {
    id: 'UA-111243779-1',
    checkDuplicatedScript: true
});

Vue.use(require('vue-script2'));


Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertSuccess.name, AlertSuccess);

Vue.component('Toasted', require('vue-toasted'));
Vue.component('Hero', require('./components/Hero.vue'));
Vue.component('Save', require('./components/Save.vue'));
Vue.component('Login', require('./components/Login.vue'));
Vue.component('Paginator', require('./components/Paginator.vue'));
Vue.component('Googlemap', require('./components/Map.vue'));
Vue.component('Review', require('./components/Review.vue'));
Vue.component('Placesearch', require('./components/SearchPlace.vue'));
Vue.component('Eventsearch', require('./components/SearchEvent.vue'));
Vue.component('Babytoddlersearch', require('./components/SearchBabyToddler.vue'));
Vue.component('Afterschoolsearch', require('./components/SearchAfterSchool.vue'));
Vue.component('Directorysearch', require('./components/SearchDirectory.vue'));
Vue.component('Posts', require('./components/Posts.vue'));
Vue.component('Gallery', require('./components/Imageslider.vue'));
Vue.component('Userreview', require('./components/UserReview.vue'));
Vue.component('Comment', require('./components/Comment.vue'));
Vue.component('Googleanalytics', require('./components/GA.vue'));
Vue.component('Mobilenav', require('./components/Mobilenav.vue'));
Vue.component('Mobilesitenav', require('./components/Mobilesitenav.vue'));
Vue.component('Userlistingitem', require('./components/UserListingItem.vue'));
Vue.component('Flash', require('./components/Flash.vue'));
Vue.component('mailchimp', require('./components/MailchimpForm.vue'));
Vue.component('Sitesearch', require('./components/Algolia/SiteSearch.vue'));
Vue.component('Sitesearchaskmum', require('./components/Algolia/SiteSearchAskMum.vue'));

Vue.component('Signinbutton', require('./components/SigninButton.vue'));
Vue.component('Loginmodal', require('./components/LoginModal.vue'));
Vue.component('Registermodal', require('./components/RegisterModal.vue'));

/* User Components */
Vue.component('Profile', require('./components/user/Profile/Profile.vue'));
Vue.component('Planner', require('./components/user/Planner.vue'));
Vue.component('Plannerfilters', require('./components/user/PlannerFilters.vue'));

/** Adverts */
// Vue.component('Leaderboard', require('./components/adverts/Leaderboard.vue'));
// Vue.component('Billboard', require('./components/adverts/Billboard.vue'));
// Vue.component('Mpu', require('./components/adverts/Mpu.vue'));

/**
 * Searches and filters
 */
Vue.component('Search', require('./components/search/Search.vue'));
// Vue.component('Results', require('./components/search/Results.vue'));
// Vue.component('Filters', require('./components/search/Filters.vue'));

Vue.use(Toasted)

const app = new Vue({
    el: '#app'
});

/**
 * JS Events
 */
if (document.documentElement.classList.contains('planner-wrap')) {
    document.getElementById("sidebar-toggle").addEventListener("click", function (e) {
        e.preventDefault();

        let div = document.getElementById("user-sidebar");
        div.classList.toggle("is-minimised");
    });

    document.getElementById("results-btn").addEventListener("click", function (e) {
        e.preventDefault();

        let div = document.getElementById("user-sidebar");
        div.classList.add("is-minimised");
    });

    if ( document.body.clientWidth < 600 ) {
        let div = document.getElementById("user-sidebar");
        div.classList.toggle("is-minimised");
    }

    var waypoint = new Waypoint({
        element: document.getElementById('planner-header'),
        handler: function (direction) {

            if ( document.body.clientWidth > 600 ) {
                this.element.classList.toggle("is-scrolling");
                let content = document.getElementById("user-area-content");
                content.classList.toggle("header-scrolling");
            }
        }
    });
}
