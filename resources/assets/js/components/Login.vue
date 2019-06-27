<template>
    <ul class="user-nav__list o-list-bare">
        <!-- <li class="user-nav__item">
            <a :href="plannerUrl()" class="user-nav__link btn btn--planner has-icon">
                <i class="icon icon--calendar-filled"></i>
                Planner
            </a>
        </li> -->

        <li class="user-nav__item has-sub" v-if="signedIn">
            <a href="#" class="user-nav__link btn btn--account" v-text="user.name" @click.prevent="toggleSub"></a>
            <div class="user-nav__sub" v-if="showSub">
                <ul class="user-nav__sub-list">
                    <li class="user-nav__sub-item">
                        <a :href="userUrl('events')">
                            <div>My Events</div>
                        </a>
                    </li>
                    <li class="user-nav__sub-item">
                        <a :href="userUrl('places')">
                            <div>My Places</div>
                        </a>
                    </li>
                    <li class="user-nav__sub-item">
                        <a :href="userUrl('services')">
                            <div>My Services</div>
                        </a>
                    </li>
                    <li class="user-nav__sub-item">
                        <a :href="userUrl('4-plus-activites')">
                            <div>My 4+ Activities</div>
                        </a>
                    </li>
                    <li class="user-nav__sub-item">
                        <a :href="userUrl('baby-toddler')">
                            <div>My Baby &amp; Toddler Groups</div>
                        </a>
                    </li>
                    <li class="user-nav__sub-item">
                        <a :href="userUrl('reviews')">
                            <div>My Reviews</div>
                        </a>
                    </li>
                    <li class="user-nav__sub-item">
                        <a :href="userUrl('profile')">
                            <div>My Profile</div>
                        </a>
                    </li>
                    <li class="user-nav__sub-item">
                        <a href="/logout">
                            <div>Logout</div>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- <li class="user-nav__item" v-if="! signedIn">
            <a href="#" class="user-nav__link btn btn--account" @click.prevent="showModal = true">
                Sign in <span>or</span> create an account
            </a>
        </li> -->

        <!-- <LoginModal v-if="showModal" @close="showModal = false" @handleModal="toggelModal($event)" @toggleRegisterModal="toggleRegisterModal('toggle')"></LoginModal> -->
    </ul>
</template>

<script>
    import moment from 'moment';

    export default {

        data() {
            return {
                showModal: false,
                showRegisterModal: false,
                showSub: false
            }
        },

        methods: {
            toggelModal(val) {
                this.showModal = false;
            },

            toggelModalEvent(val) {
                this.showRegisterModal = false;
            },

            toggleRegisterModal(val) {
                this.showModal         = false;
                this.showRegisterModal = true;
            },

            toggleSub() {
                if ( ! this.showSub) {
                    this.showSub = true;
                }
                else {
                    this.showSub = false;
                }
            },

            plannerUrl() {
                return `${location.origin}/${window.App.site}/planner/${moment().format('YYYY-MM-DD')}/`;
            },

            userUrl(page) {
                return `${location.origin}/${window.App.site}/users/${page}/`;
            }
        }
    }
</script>
