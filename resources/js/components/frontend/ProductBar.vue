<template>
    <a class="product-bar m-2" :href="'/products/' + product.code" @mouseenter="mouseover"   @mouseleave="mouseleave">
        <div class="product-details" v-show="hover" @mouseenter.stop @mouseover.stop>
            <p>{{product.title}}</p>
            <p>{{product.price}} грн.</p>
        </div>
        <img  :src="'/storage/images/' + product.images[0].medium" @mouseenter.stop @mouseover.stop alt="">
    </a>
</template>

<script>
    export default {
        props: {
            product: {}
        },
        data() {
            return {
                hover: false,
            }
        },
        methods: {
            mouseover() {
                this.hover=true;
            },
            mouseleave() {
                this.hover=false;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .product-bar {
        position: relative;

        * {
            pointer-events: none;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
            font-size: 1.2rem;
            color: #fff;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background: rgba(1, 1, 1, 0.5);
        }

        display: block;
        border: 1px solid red;

        img {
            pointer-events: none;
            max-width: 100%;
        }
    }
</style>
