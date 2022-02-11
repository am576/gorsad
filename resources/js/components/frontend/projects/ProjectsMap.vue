<template>
    <div style="height: 500px">
        <l-map ref="projectsMap"
               :center="center"
               :zoom="zoom"
               :options="mapOptions">
            <l-tile-layer
                :url="url"
                :attribution="attribution"

            />
        </l-map>
    </div>
</template>

<script>
    import { latLng } from "leaflet";
    import { LMap, LTileLayer, LMarker, LPopup, LTooltip } from "vue2-leaflet";

    export default {
        components: {
            LMap,
            LTileLayer,
            LMarker,
            LPopup,
            LTooltip
        },
        data() {
            return {
                map: {},
                zoom: 13,
                center: latLng(54.7064900, 20.5109500),
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                attribution:
                    '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                mapOptions: {
                    zoomSnap: 0.5
                },

            }
        },
        mounted() {
            this.$nextTick(() => {
                this.map = this.$refs.projectsMap.mapObject;
            });
        },
    }
</script>
