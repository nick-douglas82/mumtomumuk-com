<template>
    <transition name="fade">
        <div class="alert alert-success" v-show="show">
            <header>
                <div class="alert-icon">
                    <div class="checkmark"></div>
                </div>
                <span class="close" @click="forceHide">
                    &times;
                </span>
            </header>
            <strong v-html="heading"></strong>
            <span v-html="body"></span>
        </div>
    </transition>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: this.message,
                heading: this.title,
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash();
            }

            window.events.$on(
                'flash', data => this.flash(data)
            );
        },

        methods: {
            flash(data) {
                if (data) {
                    this.body    = data.message;
                    this.heading = data.title;
                }

                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            },

            forceHide() {
                this.show = false;
            }
        }
    }
</script>

<style lang="scss" scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
}

.alert {
    position: fixed;
    bottom: 25px;
    right: 25px;
    box-shadow: 0px 0px 29px 2px rgba(0,0,0,0.10);
    padding: 20px;
    border-radius: 10px;
    max-width: 300px;
    width: 100%;
}

.alert > strong {
    display: block;
}

.alert > span {
    color: #909090;
}

.alert-icon {
    background-color: #e57a55;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

header {
    margin-bottom: 10px;
    font-size: 40px;
}

.close {
    line-height: 0.8;
    position: absolute;
    top: 0;
    right: 10px;
    cursor: pointer;
}

.checkmark {
    display:inline-block;

    &:after{
        content: '';
        display: block;
        width: 12px;
        height: 21px;
        border: solid #ffffff;
        border-width: 0 6px 6px 0;
        transform: rotate(45deg);
        position: relative;
        top: -2px;
    }
}
</style>

