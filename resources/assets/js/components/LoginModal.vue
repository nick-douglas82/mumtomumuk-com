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
                            <h2>Sign in</h2>

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

                            <button :disabled="form.busy" class="btn btn--primary">Log in</button>

                            <div class="form__text">or</div>

                            <a href="/auth/milton-keynes/facebook" class="btn btn--facebook">Login with Facebook</a>

                            <a href="#" class="form__link">Forgotten your password?</a>

                            <hr>

                            Don't want to use Facebook login? <a href="#" class="form__link form__link--alt" @click.prevent="handleRegister">Sign up here</a>
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
                    password: '',
                }),
                remember: false,
                active: false,
                registerInActive: false,
            }
        },

        mounted() {
            Bus.$on('signInActive', signInActive => {
                this.active = signInActive;
            });

            Bus.$on('registerInActive', registerInActive => {
                this.registerInActive = registerInActive;
            });
        },

        methods: {
            login() {
                this.form.post('/login')
                    .then(({ data }) => {
                        this.$emit("handleModal");
                        this.refreshSite();
                    });
            },

            refreshSite() {
                location.reload();
            },

            toggleModal() {
                this.active = false;
                Bus.$emit('signInActive', false);
                document.documentElement.classList.toggle('overlay-active');
            },

            handleRegister() {
                this.active = false;
                (this.registerInActive) ? this.registerInActive = false : this.registerInActive = true;
                Bus.$emit('registerInActive', this.registerInActive);
            }
        }
    }
</script>
