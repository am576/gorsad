<template>
    <div class="d-flex wr1">
        <div class="row wr2">
            <div class="row wr3 justify-content-center">
                <div class="product-wrapper" v-for="(product, index) in products_all" style="" infinite-wrapper>
                    <a class="product-link" :href="'/shop/products/'+product.id" @mouseenter="hoverProduct(index)" @mouseleave="unHover()">
                        <div class="product-card" v-bind:style="{'background-image':productThumbnail(product)}" :class="{scaled: hoveredIndex === index + 1}">
                            <span v-if="!isGuest" class="favorite mdi mdi-24px" v-bind:class="isProductFavorite(product.id)" @click.prevent="toggleProductFavorite(product.id)"></span>
                            <span class="compare mdi mdi-24px mdi-format-horizontal-align-center" v-bind:class="isSetToCompare(product.id)" @click.prevent="toggleProductCompare(product.id)"></span>
                            <p class="description">
                                <span class="w-100" v-show="hoveredIndex === index + 1">{{product.title_lat}}</span>
                                <span class="d-block">{{product.title}}</span>
                            </p>
                        </div>
                    </a>
                </div>
                <infinite-loading v-show="!hasFilterOptions" :identifier="infiniteId" @distance="100" @infinite="infiniteHandler" force-use-infinite-wrapper></infinite-loading>
            </div>
        </div>
        <signin-form ref="signinForm"></signin-form>
    </div>
</template>

<script>
    export default {
        props: {
            products: {
                type: Array
            },
            user: {
                type: Object
            },
            productsToCompare: {
                type: Array,
                default: []
            },
            hasFilterOptions: Boolean
        },
        data() {
            return {
                products_all: {
                    type: Array
                },
                page: 2,
                favorites: [],
                filterShown: true,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                hoveredIndex : 0,
                infiniteId: +new Date(),
            }
        },
        methods: {
            toggleProductFavorite(id) {
                axios.post('/favorite', {
                    product_id : id
                })
                .then(() => {
                    if(this.favorites.includes(id)) {
                        this.$delete(this.favorites, this.favorites.indexOf(id))
                    }
                    else {
                        this.favorites.push(id);
                    }
                })
            },
            hoverProduct(index) {
                this.hoveredIndex = index + 1;
            },
            unHover() {
                this.hoveredIndex = -1;
            },
            getUserFavorites() {
                if(this.user !== null) {
                    axios.get('/getfavorites')
                        .then(res => {
                            this.favorites = res.data;
                        })
                }
            },
            isProductFavorite(id) {
                return {
                    'mdi-heart' : this.favorites.includes(id),
                    'mdi-heart-outline' : !this.favorites.includes(id),
                }
            },
            toggleComparisonPage() {
                this.toggleFilters();
                if(this.showComparison === false) {
                    this.showComparison = true;
                    axios.get('/shop/comparison')
                        .then(response => {
                            this.compareProducts = response.data;
                        })
                }
                else {
                    this.showComparison = false;
                }
            },
            toggleProductCompare(id) {
                this.$eventBus.$emit('toggleProductCompare', id)
            },
            isSetToCompare(id) {
                return this.productsToCompare.includes(id) ? 'set_to_compare' : '';
            },
            productThumbnail(product) {
                if(product.image) {
                    return `url(/storage/images/${product.image.medium})`
                }
            },
            showSigninForm() {
                this.$refs.signinForm.showModal();
            },
            logout() {
                this.$refs.logout.submit()
            },
            showCart() {
                this.$eventBus.$emit('showCart')
            },
            infiniteHandler($state) {
                if(!this.hasFilterOptions) {
                    axios.get('/shop/load?page=' + this.page)
                        .then(response => {
                            return response.data;

                        }).then(data => {
                        $.each(data.data, (key, value) => {
                            this.products_all.push(value);
                        });
                        $state.loaded();
                    });

                    this.page = this.page + 1;
                }
            },
            resetLoader() {
                this.page = 1;
                this.products_all = [];
                this.infiniteId += 1;
            },
            updateProductsList(products, isFilter) {
                this.products_all = products;
                this.hasFilterOptions = isFilter;
            }
        },
        computed: {
            isGuest() {
                return this.user == null;
            },
        },
        created() {
            this.products_all = this.products;
            this.$eventBus.$on('resetLoader', this.resetLoader)
            this.$eventBus.$on('updateProductsList', this.updateProductsList)
            this.getUserFavorites();
        }
    }
</script>
<style lang="scss">
    .product-wrapper {
        padding: 10px;
        @media (min-width: 0px) {
            width: 100%;
        }
        @media (min-width: 400px) {
            width: 50%;
        }
        @media (min-width: 800px) {
            width: 33.33333%;
        }
        @media (min-width: 1200px) {
            width: 25%;
        }
        @media (min-width: 1600px) {
            width: 20%;
        }
    }
    .product-link {
        &:hover {
            text-decoration: none;
        }
    }
    .product-card {
        position: relative;
        &.scaled {
            animation: slidein 0.25s;
            -webkit-animation-fill-mode: forwards; /* Safari 4.0 - 8.0 */
            animation-fill-mode: forwards;

            @keyframes slidein {
                from {
                    transform: scale(1);
                }

                to {
                    transform: scale(1.025);
                }
            }
        }
    }
    .favorite, .compare {
        position: absolute;
        top: 5px;
        color: #fff;
        width: 35px;
        text-align: center;
        border-radius: 50px;
        background-color: rgba(40, 40, 40, 0.27);
    }
    .favorite {
        right: 45px;
    }
    .compare {
        right: 5px;
    }
    .compare.set_to_compare {
        background-color: rgba(179, 155, 85, 0.91);;
    }
    .wr1 {
        justify-content: center;
        background-color: #343434;

        .wr2 {
            width: 100%;
            justify-content: center;
            padding: 25px 0;
            background-color: #434242;
            .wr3 {
                width: 100%;
                padding: 5px;
                background-color: #403d3d;
            }
        }
    }

    .nav-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: none;
        border-radius: 3px;
        background-color: #4a4848;
        color: #ffffff;

        &:hover {
            background-color: #605b5b;
        }
    }

    #btn-login {
        min-width: 100px;
        padding: 5px 15px 5px 10px;
    }
    #nav-buttons {
        display: flex;
        align-items: center;
        @media (max-width:600px) {
            display: none;
        }
        .show_compare {
            background-color: #868278;;
        }
    }
    .infinite-loading-container [class^="loading-"] {
        width: 60px !important;
        height: 60px !important;
    }
</style>
