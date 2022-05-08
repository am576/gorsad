<template>
    <div class="row slider-wrapper product-images justify-content-center">
        <splide :options="options" @splide:click="showImage">
            <splide-slide v-for="image in product.images" :key="image.medium" >
                <img :src="'/storage/images/' + image.medium" alt="">
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
                    type: 'slide',
                    width: '100%',
                    height: 300,
                    gap   : '2rem',
                    keyboard: false,
                    pagination: false,
                    rewind: false,
                    perPage: 1,
                    fixedWidth:300,
                    cover: true,
                    isMobileView: false
                },
                isMobileView: false,
                images: []
            }
        },
        methods: {
            showImage(slide, e) {
                this.$eventBus.$emit('showImageModal', e.index)
                this.current_image = this.images[e.index];
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
    }
</style>
