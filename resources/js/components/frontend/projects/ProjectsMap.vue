<template>
    <div id="map-wrapper">
        <l-map ref="projectsMap"
               :center="center"
               :zoom="zoom"
               :options="mapOptions">
            <l-tile-layer
                :url="url"
                :attribution="attribution"
            />
            <l-marker v-for="(project, index) in projects" :key="index" :lat-lng="[project['lat'], project['long']]" :icon="mapIcon(index)" @click="gotoProject(project.id)">
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
    import { latLng, icon } from "leaflet";
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
                // attribution:
                //     '&copy; <a style="font-size: 12px;" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                mapOptions: {
                    zoomSnap: 0.5,
                    attributionControl: false,
                    zoomControl: true,
                    scrollWheelZoom: false
                },
                icon: icon({
                    iconUrl: "/storage/images/public/tree-marker.png",
                    iconSize: [54, 72],
                    iconAnchor: [16, 37]
                }),
                iconsAvailable : 6,
            }
        },
        methods: {
            gotoProject(id) {
                window.location.href = `/projects/${id}`;
            },
            mapIcon(index) {
                let iconIndex = index - this.iconsAvailable*(Math.trunc(index/this.iconsAvailable));
                return icon({
                    iconUrl: `/storage/images/public/map/marker${iconIndex}.png`,
                    iconSize: [31, 42],
                    iconAnchor: [16, 37]
                })
            },
            handleView() {
                this.mapOptions.zoomControl = !(window.innerWidth <= 600);
            },
        },
        mounted() {
            this.$nextTick(() => {
                this.map = this.$refs.projectsMap.mapObject;
            });
        },
        created() {
            this.handleView();
        }
    }
</script>

<style lang="scss" scoped>
    #map-wrapper {
        height: 500px;
        @media(max-width: 600px) {
            height: 50vh;
        }
    }
</style>
