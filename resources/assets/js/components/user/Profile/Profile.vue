<template>
    <div class="user__content-wrap">
        <header class="user__header">
            <div class="title">My Profile</div>
        </header>

        <main class="content profile">

            <div class="user-message success" v-if="success">Your profile has been successfully updated.</div>

            <Information
                :firstname="firstname"
                :lastname="lastname">
            </Information>

            <Account
                :email="email"
                :usingsocial="usingsocial"
                :provider="provider">
            </Account>

            <div class="group__item push-right">
                <button class="btn btn--primary" :disabled=" ! validAccount" @click.prevent="submit">Save</button>
            </div>

        </main>

    </div>
</template>

<script>

    import { Bus } from '../../../events';
    import Information from "./Information.vue";
    import Account from "./AccountInformation.vue";

    export default {

        props: [ 'firstname', 'lastname', 'email', 'usingsocial', 'provider'],

        components: { Information, Account },

        data() {
            return {
                params: {},
                validAccount: true,
                success: false
            }
        },

        created() {
            Bus.$on('name', name => {
                this.params.name = name;
            });

            Bus.$on('email', email => {
                this.params.email = email;
            });

            Bus.$on('password', password => {
                this.params.password = password;
            });
        },

        methods: {
            submit() {
                axios.patch(`${location.href}`, {
                    params: this.params
                })
                .then(({ data }) => {

                    if (data.errors.length > 0) {

                        data.errors.forEach(function (item, key) {
                            Bus.$emit('formErrors', item);
                        });
                    }
                    else {
                        this.success = true;
                    }
                });
            }
        }
    }
</script>
