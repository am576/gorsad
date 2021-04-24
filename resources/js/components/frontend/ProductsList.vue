<template>
    <div class="row">
        <div v-for="product in products" style="width: 20%; padding: 10px">
            <a :href="'/products/'+product.id">
                <div class="product-card" v-bind:style="{'background-image':'url(/storage/images/' + product.images[0].medium +')'}">
                    <span class="favorite mdi mdi-24px" v-bind:class="isProductFavorite(product.id)" @click.prevent="toggleProductFavorite(product.id)"></span>
                    <p class="description">{{product.title}}</p>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            products: {
                type: Array
            },
        },
        data() {
            return {
                favorites: []
            }
        },
        methods: {
            toggleProductFavorite(id) {
                axios.post('/favorite', {
                    product_id : id
                })
                .then(res => {
                    if(this.favorites.includes(id)) {
                        this.$delete(this.favorites, this.favorites.indexOf(id))
                    }
                    else {
                        this.favorites.push(id);
                    }
                })
            },
            getUserFavorites() {
                axios.get('/getfavorites')
                .then(res => {
                    this.favorites = res.data;
                })
            },
            isProductFavorite(id) {
                return {
                    'mdi-heart' : this.favorites.includes(id),
                    'mdi-heart-outline' : !this.favorites.includes(id),
                }
            }
        },
        computed: {

        },
        created() {
            this.getUserFavorites();
        }
    }
</script>
<style lang="scss" scoped>
    .product-card {
        position: relative;
    }
    .favorite {
        position: absolute;
        top: 5px;
        right: 5px;
    }
</style>
