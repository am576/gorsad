<template>
    <div class="modal-overlay" :class="showModal ? 'd-flex' : 'd-none'">
        <div class="imodal">
            <span class="close-modal mdi mdi-48px mdi-close-circle-outline text-white" @click="showModal = false"></span>
            <img :src="'/storage/images/'+current_image.large" alt="" style="width: 100%;">
            <span class="left-control mdi mdi-chevron-left text-white" v-show="!isFirstImage" @click="showPreviousImage"></span>
            <span class="right-control mdi mdi-chevron-right text-white" v-show="!isLastImage" @click="showNextImage"></span>
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
                if (event.keyCode === 27) {
                    this.showModal = false;
                }
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
            }
        },
        computed: {
            isFirstImage() {
                return this.image_index === 0;
            },
            isLastImage() {
                console.log(this.images.length - 1)
                return this.image_index === this.images.length - 1;
            }
        },
        created: function() {
            document.addEventListener('keyup', this.keyPressed);
            this.$eventBus.$on('showModal', this.setModalVisibility);
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
            width: 700px;
            margin-top: 5%;
            display: flex;
            align-items: center;

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
            .close-modal {
                position: absolute;
                top: -50px;
                right: -50px;
                cursor: pointer;
            }
        }
    }

</style>
