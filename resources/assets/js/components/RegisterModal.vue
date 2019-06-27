<template>
    <transition name="modal" v-if="active">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="close__button close--modal" @click="toggleModal">
                        <div class="close">
                            <span></span>
                            <span></span>
                        </div>
                    </div>

                    <div class="modal-body">

                        <form role="form" class="form form--login" @submit.prevent="login" @keydown="form.errors.clear($event.target.name)">
                            <h2>Register</h2>

                            <has-error :form="form" field="name"></has-error>
                            <input
                                type="text"
                                name="name"
                                class="form__input"
                                placeholder="Name"
                                v-model="form.name"
                                :class="{ 'is-invalid': form.errors.has('name') }">

                            <has-error :form="form" field="email"></has-error>
                            <input
                                type="text"
                                name="email"
                                class="form__input"
                                placeholder="Email"
                                v-model="form.email"
                                :class="{ 'is-invalid': form.errors.has('username') }">

                            <has-error :form="form" field="password"></has-error>
                            <input
                                type="password"
                                name="password"
                                class="form__input"
                                placeholder="Password"
                                v-model="form.password"
                                :class="{ 'is-invalid': form.errors.has('password') }">

                            <has-error :form="form" field="password_confirmation"></has-error>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form__input"
                                placeholder="Password"
                                v-model="form.password_confirmation"
                                :class="{ 'is-invalid': form.errors.has('password_confirmation') }">

                            <button :disabled="form.busy" class="btn btn--primary">Register</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>

    import Form from 'vform';
    import { Bus } from '../events';

    export default {

        data() {
            return {
                form: new Form({
                    username: '',
                    name: '',
                    password: '',
                    password_confirmation: '',
                }),
                remember: false,
                active: false
            }
        },

        mounted() {
            Bus.$on('registerInActive', registerInActive => {
                this.active = registerInActive;
            });
        },

        methods: {
            login () {
                this.form.post('/register')
                    .then(({ data }) => {
                        this.$emit("handleModal");
                        this.refreshSite();
                    });
            },

            toggleModal() {
                this.active = false;
                Bus.$emit('registerInActive', false);
                Bus.$emit('signInActive', false);
                document.documentElement.classList.toggle('overlay-active');
            },

            refreshSite () {
                location.reload();
            }
        }
    }
</script>
