<template>
    <div class="d-flex slider-wrapper project-images">
        <splide :options="options" @splide:click="showImage">
            <splide-slide v-for="image in images" :key="image.path" >
                <div class="splide-cover" v-bind:style="{'background-image':'url(/storage/images/' + image.medium +')'}"></div>
            </splide-slide>
            <template v-slot:controls v-if="!isMobileView">
                <div class="splide__arrows">
                    <button class="splide__arrow splide__arrow--prev">
                        <span class="mdi mdi-chevron-left"></span>
                    </button>
                    <button class="splide__arrow splide__arrow--next">
                        <span class="mdi mdi-chevron-right"></span>
                    </button>
                </div>
            </template>
        </splide>
        <image-modal :images="images"></image-modal>
    </div>
</template>

<script>
    import '@splidejs/splide/dist/css/themes/splide-default.min.css';
    import { Splide, SplideSlide } from '@splidejs/vue-splide';

    export default {
        components: {
            Splide,
            SplideSlide,
        },
        props: {
            project: {}
        },
        data() {
            return {
                current_image: '',
                options: {
                    type: 'loop',
                    width: '1150px',
                    height: '300px',
                    gap   : '2rem',
                    pagination: false,
                    perPage: 10,
                    heightRatio: 2,

                },
                isMobileView: false,
                images: []
            }
        },
        methods: {
            showImage(slide, e) {
                let image_index = e.index;
                if(e.index > (this.images.length - 1)) {
                    image_index = e.index - this.images.length;
                }
                this.setCurrentImage(this.images[image_index]);
                this.$eventBus.$emit('showImageModal', image_index)
            },
            setCurrentImage(image) {
                this.current_image = image;
            },
            handleView() {
                this.isMobileView = window.innerWidth <= 1200;
            },
        },
        created() {
            this.images = this.project.images;
            this.setCurrentImage(this.images[0]);
            this.handleView();
        }
    }
</script>

<style lang="scss" scoped>
    .thumbs {
        .thumb-link {
            cursor: pointer;
            border: 1px solid #1b4b72;
        }
        .thumb-image {
            height: 100px;
            display: block;
            background-size: cover;
            background-position: center;
        }
    }

    .preview {
        img {
            width: 100%;
        }
    }

    .project-images.slider-wrapper {
        padding: 0 30px;
        @media(max-width: 1300px) {
            max-width: 900px !important;
        }
        @media(max-width: 1200px) {
            max-width: 100% !important;
        }
        @media(max-width: 600px) {
            max-width: 100% !important;
        }

        .splide__arrow {
            width: 4rem;
            height: 4rem;
            opacity: 1;
            background: transparent;
            .mdi {
                font-size: 100px;
                color: #8d8d8d;
            }
        }
        .splide__arrow--prev {
            position: absolute;
            left: 0;
            margin-left: -10%;
        }
        .splide__arrow--next {
            position: absolute;
            right: 0;
            margin-right: -10%;
        }
        .splide__slide {
            cursor: pointer;
        }
        li {
            width: 300px !important;
            .splide-cover {
                width: 300px;
                height: 100%;
                background-size: cover;
            }
        }

    }
</style>
