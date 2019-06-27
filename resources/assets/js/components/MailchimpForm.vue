<template>
    <div>
        <span v-if="subscribeMessage" class="subscribeMessage"><p v-html="subscribeMessage"></p></span>
        <form class="form" action="https://relocating2.us13.list-manage.com/subscribe/post-json?u=95415b520b3ec3037f6304480&amp;id=785377bdd2&c=?" method="post">
            <input type="email"
                name="EMAIL"
                class="form__input"
                placeholder="email address"
                id="mce-EMAIL"
                v-model="info.email"
                :class="{ error: showFieldError() }"
                @focus="emailEmpty = false">

            <div style="position: absolute; left: -5000px;" aria-hidden="true">
                <input type="text" name="b_95415b520b3ec3037f6304480_785377bdd2" tabindex="-1" value="" v-model="info.secure">
            </div>

            <button class="btn btn--alt is-short" @click.prevent="submit">Sign me up</button>
        </form>
    </div>
</template>

<script>
    import $ from 'jquery';

    export default {


        data() {
            return {
                action: 'https://relocating2.us13.list-manage.com/subscribe/post-json?u=95415b520b3ec3037f6304480&amp;id=785377bdd2&c=?',
                info: {
                    email: '',
                    secure: '',
                },
                emailEmpty: false,
                validEmail: true,
                validForm: false,
                subscribeMessage: ''
            }
        },

        methods: {
            submit() {
                this.validate();

                if (this.validForm) {

                    var $form = $('.form');

                    $.ajax({
                        context: this,
                        type: $form.attr('method'),
                        url: $form.attr('action'),
                        data: $form.serialize(),
                        cache: false,
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8',
                        success: function (data) {
                            this.subscribeMessage = data.msg;
                            this.formReset();
                        }
                    });

                }
            },

            formReset() {
                this.info.email = '';
                this.emailEmpty = false;
                this.validEmail = true;
                this.validForm  = false;
            },

            /**
             * Validation
             */
            validate() {
                this.emptyEmail();

                if ( !this.emailEmpty ) {
                    this.validEmail = this.validateEmail();
                }

                this.validForm = ( !this.emailEmpty && this.validEmail ) ? true : false;
            },

            validateEmail() {
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

                if ( !reg.test(this.info.email) ) {
                    return false;
                }

                return true;
            },

            emptyEmail() {
                this.emailEmpty = (this.info.email == '') ? true : false;
            },

            showFieldError() {
                return ( !this.validEmail || this.emailEmpty || !this.validEmail && this.emailEmpty ) ? true : false;
            }
        }
    }
</script>

<style lang="scss" scoped>

.form__input {
    &.error {
        border: 1px solid red;
    }
}

.subscribeMessage {
    font-size: 18px;
}

</style>

