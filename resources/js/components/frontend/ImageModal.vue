<template>
    <div class="modal-overlay" :class="showModal ? 'd-flex' : 'd-none'" @click.prevent.stop="hideModal">
        <div class="imodal">
            <span class="close-modal mdi mdi-48px mdi-close-circle-outline text-white" @click.stop="showModal = false"></span>
            <div class="image d-flex position-relative">
                <img :src="'/storage/images/'+current_image.large" alt="загрузка изображения..." @click.stop>
                <span class="left-control mdi mdi-chevron-left text-white" v-show="!isFirstImage"
                      @click.stop="showPreviousImage"></span>
                <span class="right-control mdi mdi-chevron-right text-white" v-show="!isLastImage"
                      @click.stop="showNextImage"></span>
            </div>
        </div>
        <div class="close">
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            images: Array
        },
        data() {
            return {
                showModal: false,
                current_image: null,
                image_index: 0
            }
        },
        methods: {
            keyPressed(event) {
                switch (event.keyCode) {
                    case 27:
                        this.showModal = false;
                        break;
                    case 39:
                        this.showNextImage();
                        break;
                    case 37:
                        this.showPreviousImage();
                        break;
                }
            },
            hideModal() {
                this.showModal = false;
            },
            setModalVisibility(image_index) {
                this.current_image = this.images[image_index];
                this.image_index = image_index;
                this.showModal = true;
            },
            showPreviousImage() {
                if(this.image_index - 1 >= 0) {
                    this.current_image = this.images[this.image_index - 1]
                    this.image_index--;
                }
            },
            showNextImage() {
                if(this.image_index + 1 <= this.images.length) {
                    this.current_image = this.images[this.image_index + 1]
                    this.image_index++;
                }
            },
        },
        computed: {
            isFirstImage() {
                return this.image_index === 0;
            },
            isLastImage() {
                return this.image_index === this.images.length - 1;
            }
        },
        created: function() {
            document.addEventListener('keyup', this.keyPressed);
            this.$eventBus.$on('showImageModal', this.setModalVisibility);
            this.current_image = this.images[0];
        }
    }
</script>
<style lang="scss" scoped>
    .modal-overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        justify-content: center;
        background-color: #000000da;
        z-index: 100;

        .imodal {
            position: relative;
            text-align: center;
            max-height: 700px;
            width: 60vw;
            margin-top: 5%;
            padding-bottom: 10vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            .image {
                max-height: 70vh;
                width: 60vw;
                display: flex;
                justify-content: center;
                align-items: center;
                color: #ffffff !important;
                .left-control, .right-control {
                    position: absolute;
                    font-size: 100px;
                    cursor: pointer;
                }

                .left-control {
                    left: -100px;
                }

                .right-control {
                    right: -100px;
                }

                img {
                    max-width: 100%;
                    max-height: 100%;
                }
            }
        }
        .close-modal {
            position: static !important;
            align-self: end;
        }
    }
</style>
