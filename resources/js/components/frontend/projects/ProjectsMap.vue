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
            <l-marker v-for="(project, index) in projects" :key="index" :lat-lng="[project['lat'], project['long']]" :icon="icon" @click="gotoProject(project.id)">
                <l-tooltip :options="{ permanent: false, interactive: true }">
                    <div>
                        {{project.name}}
                    </div>
                </l-tooltip>
            </l-marker>
        </l-map>
    </div>
</template>

<script>
    // import { latLng, icon } from "leaflet";
    import { LMap, LTileLayer, LMarker, LPopup, LTooltip, LIcon } from "vue2-leaflet";

    export default {
        components: {
            LMap,
            LTileLayer,
            LMarker,
            LPopup,
            LTooltip,
            LIcon
        },
        props: {
            projects: {
                type: Array,
            }
        },
        data() {
            return {
                zoom: 10,
                center: latLng(54.7064900, 20.5109500),
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                attribution:
                    '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                mapOptions: {
                    zoomSnap: 0.5
                },
                icon: icon({
                    iconUrl: "/storage/images/public/tree-marker.png",
                    iconSize: [64, 64],
                    iconAnchor: [16, 37]
                }),
            }
        },
        methods: {
            gotoProject(id) {
                window.location.href = `/projects/${id}`;
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.map = this.$refs.projectsMap.mapObject;
            });
        },
    }
</script>
