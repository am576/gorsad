<template>
    <div class="container">
        <div class="row justify-content-start" v-if="products.length">
            <div v-for="product in products" class="col-md-3 col-sm-6">
                <a :href="'/shop/products/'+product.id" target="_blank">
                    <div class="product-card" v-bind:style="{'background-image':'url(/storage/images/' + product.image.medium +')'}">
                        <p class="description">{{product.title}}</p>
                        <span class="unfavorite mdi mdi-trash-can" @click.prevent="unfavoriteProduct(product)"></span>
                    </div>
                </a>
            </div>
        </div>
        <div v-else>
            <h4>Вы пока не добавляли растения в избранное</h4>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            favorites: {
                type: Array
            }
        },
        data() {
            return {
                products: [],
            }
        },
        methods: {
            unfavoriteProduct(product) {
                axios.post('/favorite', {
                    product_id : product.id
                })
                    .then(res => {
                        this.$delete(this.products, this.products.indexOf(product));
                    })
            },
        },
        created() {
            this.products = this.favorites;
        }
    }
</script>
<style lang="scss" scoped>
    .product-card {
        position: relative;
        margin-bottom: 2rem;
        .mdi-trash-can {
            font-size: 32px !important;
            color: #ffffff;
            &:hover {
                color: #e0e0e0;
            }
        }
        @media (max-width:600px) {
            height: 80vw;
            margin-bottom: 6vh;
            .mdi-trash-can {
                font-size: 3vh !important;
                color: #ffffff;
            }
        }
    }
    .unfavorite {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
