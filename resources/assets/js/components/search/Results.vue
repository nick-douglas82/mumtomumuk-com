<template>
    <div>
        <div v-if="results.length > 0">
            <div v-for="(item, index) in results" :key="index" class="search-item">
                <a href="#" class="o-grid o-container">
                    <div class="search-item__image">
                        <img v-bind:src="mainimage(item.media)" :alt="item.title">
                    </div>
                    <div class="search-item__content">
                        <h2 class="search-item__title" v-html="item.title"></h2>
                        <h3 class="search-item__location" v-if="item.event_at">{{ item.event_at | eventdate }} - {{ item.event_end | time }}</h3>
                        <h3 class="search-item__location">{{ item.town }}</h3>
                        <div class="body-content" v-html="truncate(item.body, '140')"></div>
                        <p v-if="item.averageRating">Avg Rating: {{ ratingdisplay(item.averageRating, item.reviews.length) }}</p>
                    </div>
                </a>
                <div class="o-grid o-container">
                    <div class="search-item__features">
                        <div class="search-item__tag">Free</div>
                        <Save :issaved="item.isFavorited"
                            :favtype="type"
                            :slug="item.slug"
                            :title="item.title"
                            :endpoint="endpoint"
                            cssclasses="btn btn--primary has-icon is-square">
                        </Save>
                    </div>
                </div>
            </div>
        </div>
        <div v-else><p>Sorry there are no results.</p></div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props: [ 'results', 'type', 'endpoint' ],

        methods: {
            truncate (string, length) {
                let trimmedString = string.substr(0, length);

                return trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" "))).replace(/(<([^>]+)>)/ig,"")
            },

            ratingdisplay (rating, reviewCount) {
                if (rating == 0 && reviewCount == 0) {
                    return 'Not reviewed yet.';
                }

                return rating;
            },

            mainimage(media) {

                let imageUrl = '';

                Object.keys(media).forEach(key => {
                    if (media[key].name === 'main_image') {
                        imageUrl = `/storage/${media[key].id}/conversions/listing.jpg`;
                    }
                });

                return imageUrl;
            }
        },

        filters: {
            eventdate (date) {
                return moment(date).format('ddd, D MMM YYYY, kk:mm');
            },

            time (date) {
                return moment(date).format('kk:mm');
            },
        }
    }
</script>
