<template>
    <div class="row slider-wrapper project-images">
        <splide :options="options" @splide:click="showImage">
            <splide-slide v-for="image in images" :key="image.path" >
                <img :src="image.path" alt="">
            </splide-slide>
            <template v-slot:controls>
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
        <b-modal id="modal-image" size="lg" hide-footer>
            <img :src="current_image" alt="" style="width: 100%;">
        </b-modal>
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
                    type: 'slide',
                    width: '100%',
                    height: 300,
                    gap   : '2rem',
                    pagination: false,
                    rewind: true,
                    perPage: 1,
                    fixedWidth:300,
                    cover: true,
                    isMobileView: false
                },
                images: [
                    {
                        path: '/storage/images/projects/project-01.jpg'
                    },
                    {
                        path: '/storage/images/projects/project-02.jpg'
                    },
                    {
                        path: '/storage/images/projects/project-03.jpg'
                    },
                    {
                        path: '/storage/images/projects/project-04.jpg'
                    },
                    {
                        path: '/storage/images/projects/project-05.jpg'
                    },
                ]
            }
        },
        methods: {
            showImage(slide, e) {
                this.$bvModal.show('modal-image');
                this.current_image = this.images[e.index].path;
            },
            setCurrentImage(image) {
                this.current_image = image.path;
            },
            handleView() {
                this.isMobileView = window.innerWidth <= 600;
                if(this.isMobileView) {
                    this.options.height = 200;
                    this.options.fixedWidth = 200;
                    this.options.width = window.innerWidth;
                }
            },
        },
        created() {
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
        max-width: 1150px !important;
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
    }
</style>
