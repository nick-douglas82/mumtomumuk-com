<template>
    <div>
        <h2 class="review__heading">Add a review</h2>
        <textarea name="review" cols="30" rows="10" class="review__textarea" v-model="review"></textarea>

        <div class="review-write__wrap">
            <button class="btn btn--primary" @click="store">Add Review</button>

            <Rating max="" :default="value" @rating="setRating"></Rating>
        </div>
    </div>
</template>

<script>
    import Rating from './Rating.vue';

    export default {
        components: { Rating },

        props: ['slug'],

        data() {
            return {
                value: 0,
                reviewRating: '',
                review: ''
            }
        },

        methods: {
            setRating(rating) {
                this.reviewRating = rating;
            },

            store() {
                axios.post(`${location.origin}/${window.App.site}/reviews/${location.pathname.split("/")[2]}/${this.slug}`, {
                    params: {
                        rating: this.reviewRating,
                        review: this.review
                    }
                }).then(this.refresh);
            },

            refresh() {
                this.review       = '';
                this.reviewRating = 0;
                this.value        = 0;

                flash(`Review submitted for approval`);
            }
        }
    }
</script>
