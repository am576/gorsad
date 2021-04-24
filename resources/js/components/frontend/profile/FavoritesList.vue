<template>
    <div class="container">
        <div class="row justify-content-start">
            <div v-for="product in products" class="col-3">
                <a :href="'/products/'+product.id">
                    <div class="product-card" v-bind:style="{'background-image':'url(/storage/images/' + product.images[0].medium +')'}">
                        <p class="description">{{product.title}}</p>
                        <span class="unfavorite mdi mdi-trash-can mdi-24px" @click.prevent="unfavoriteProduct(product)"></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: {
                type: Array
            }
        },
        data() {
            return {
                products: []
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
            }
        },
        created() {
            this.products = this.data;
        }
    }
</script>
<style lang="scss" scoped>
    .product-card {
        position: relative;
    }
    .unfavorite {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
