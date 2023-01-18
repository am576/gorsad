<template>
    <div class="row slider-wrapper product-images justify-content-center">
        <splide :options="options" @splide:click="showImage">
            <splide-slide v-for="image in product.images" :key="image.medium" >
                <div class="splide-cover" v-bind:style="{'background-image':'url(/storage/images/' + image.medium +')'}"></div>
            </splide-slide>
            <template v-slot:controls >
                <div class="splide__arrows" v-show="!isMobileView">
                    <button class="splide__arrow splide__arrow--prev">
                        <span class="mdi mdi-chevron-left-circle-outline"></span>
                    </button>
                    <button class="splide__arrow splide__arrow--next">
                        <span class="mdi mdi-chevron-right-circle-outline"></span>
                    </button>
                </div>
            </template>
        </splide>
        <image-modal :images="product.images"></image-modal>
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
            product: {}
        },
        data() {
            return {
                current_image: '',
                options: {
                    type: 'loop',
                    width: '100%',
                    height: 300,
                    gap   : '2rem',
                    keyboard: false,
                    pagination: false,
                    perPage: 10,
                    isMobileView: false
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
                this.isMobileView = window.innerWidth <= 600;
                if(this.isMobileView) {
                    this.options.height = 200;
                    this.options.fixedWidth = 200;
                    this.options.width = window.innerWidth;
                }
            },
        },
        created() {
            this.images = this.product.images;
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

    .slider-wrapper {
        padding: 0 30px;
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
