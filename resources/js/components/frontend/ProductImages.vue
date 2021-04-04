<template>
    <div class="row">
        <div class="thumbs row col-3 justify-content-start  flex-column">
            <div class="thumb-link m-2" v-for="image in product.images" @click="setCurrentImage(image)">
                <span class="thumb-image" v-bind:style="{'background-image':'url(/storage/images/' + image.icon +')'}"></span>
            </div>
        </div>
        <div class="preview col-9">
            <img :src="'/storage/images/' + current_image.large" alt="">
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            product: {}
        },
        data() {
            return {
                current_image: ''
            }
        },
        methods: {
            setCurrentImage(image) {
                this.current_image = image;
            }
        },
        created() {
            this.setCurrentImage(this.product.images[0]);
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
</style>
