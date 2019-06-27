<template>
    <div class="gallery__wrap">
        <i></i>
        <div v-for="number in [currentNumber]" transition="fade">
            <img
                :src="conversionImageLocation(images[Math.abs(currentNumber) % images.length])"
                v-on:mouseover="stopRotation"
                v-on:mouseout="startRotation"
                class="gallery__image"
            />
        </div>
        <div class="controls">
            <a @click="prev">
                <img src="../../images/svg/gallery_prev.svg" class="direction prev">
            </a>
            <a @click="next">
                <img src="../../images/svg/gallery_next.svg" class="direction next">
            </a>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['images'],

        data() {
            return {
                currentNumber: 0,
                timer: null,
                delay: 5000
            }
        },

        mounted() {
            this.startRotation();
        },

        methods: {
            startRotation: function() {
                this.timer = setInterval(this.next, this.delay);
            },

            stopRotation: function() {
                clearTimeout(this.timer);
                this.timer = null;
            },

            next: function() {
                this.currentNumber += 1
                this.stopRotation();
                this.startRotation();
            },

            prev: function() {
                this.currentNumber -= 1
                this.stopRotation();
                this.startRotation();
            },

            conversionImageLocation: function (image) {
                return `/storage/${image.id}/conversions/post.jpg`;
            }
        }
    }
</script>

<style scoped>
.direction {
    height: 21px;
    display: block;
}

.controls {
    position: absolute;
    right: 10px;
    bottom: 10px;
    display: flex;
}

.controls a {
    padding: 7px 3px;
    border-radius: 2px;
    background-color: rgba(0,0,0, 0.5);
}

.controls a:first-of-type {
    margin-right: 5px;
}
</style>

