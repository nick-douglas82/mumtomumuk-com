<template>
    <div class="map"></div>
</template>

<script>
    export default {
        props: ['longitude', 'latitude'],

        data() {
            return {
                map: ''
            }
        },

        methods: {
            createMap() {
                this.map = new google.maps.Map(document.querySelector('.map'), {
                    center: { lat: this.latitude, lng: this.longitude },
                    zoom: 13
                });
            },

            setMarker() {
                let marker = new google.maps.Marker({
                    position: { lat: this.latitude, lng: this.longitude },
                    map: this.map
                });
            }
        },

        mounted() {
            this.createMap();
            this.setMarker();
        }
    }
</script>
