<template>
    <div class="row slider-wrapper product-images">
        <!--<div class="thumbs row col-3 justify-content-start  flex-column">
            <div class="thumb-link m-2" v-for="image in product.images" @click="setCurrentImage(image)">
                <span class="thumb-image" v-bind:style="{'background-image':'url(/storage/images/' + image.icon +')'}"></span>
            </div>
        </div>
        <div class="preview col-9">
            <img :src="'/storage/images/' + current_image.large" alt="">
        </div>-->
        <splide :options="options" @splide:click="showImage">
            <splide-slide v-for="image in product.images" :key="image.medium" >
                <img :src="'/storage/images/' + image.medium" alt="">
            </splide-slide>
            <template v-slot:controls>
                <div class="splide__arrows">
                    <button class="splide__arrow splide__arrow--prev">
                        <span class="mdi mdi-chevron-left-circle-outline"></span>
                    </button>
                    <button class="splide__arrow splide__arrow--next">
                        <span class="mdi mdi-chevron-right-circle-outline"></span>
                    </button>
                </div>
            </template>
        </splide>
        <b-modal id="modal-image" size="lg" hide-footer>
            <img :src="'/storage/images/' + current_image" alt="" style="width: 100%;">
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
                    pagination: false,
                    rewind: true,
                    perPage: 1,
                    fixedWidth:300,
                    cover: true,
                    isMobileView: false
                },
            }
        },
        methods: {
            showImage(slide, e) {
                this.$bvModal.show('modal-image');
                this.current_image = this.product.images[e.index].large;
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
            this.setCurrentImage(this.product.images[0]);
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
