<template>
    <div class="row wr1">
        <div class="shop-nav">
            <div id="filter-btn-wr">
                <button class="nav-btn" id="btn-toggle-filters" @click="toggleFilters">
                    <i class="mdi mdi-24px" v-bind:class="filterShown ? 'mdi-chevron-up' : 'mdi-chevron-down'"></i>
                    {{filterBtnCaption}}
                </button>
            </div>
            <div id="nav-buttons">
                <div v-if="productsToCompare.length > 1">
                    <button class="nav-btn show_compare" @click="toggleComparisonPage">
                        <i class="mdi mdi-24px mdi-format-horizontal-align-center mr-1 mr-l1"></i>
                        Показать сравнение
                    </button>
                </div>

                <div v-if="isGuest">
                    <button class="nav-btn" id="btn-login" @click="showSigninForm">
                        <i class="mdi mdi-login"></i>
                        Войти
                    </button>
                </div>
                <div class="d-flex align-items-center" v-if="!isGuest">
                    <a class="nav-link curpointer" @click="showCart">
                        <span class="mdi mdi-cart"></span>
                    </a>
                    <b-dropdown id="account-dropdown" size="lg" right variant="link" block
                                toggle-class="text-decoration-none" no-caret>
                        <template #button-content>
                            <div class="mdi mdi-account"></div>
                        </template>
                        <b-dropdown-text>
                            <div>{{user.name}}</div>
                            <a href="/profile" class="text-small">Личный кабинет</a>
                        </b-dropdown-text>
                        <b-dropdown-text>
                            <form ref="logout" id="logout-form" action="/logout" method="POST" style="display: none;">
                                <input type="hidden" name="_token" :value="csrf">
                            </form>
                            <a class="curpointer text-small" @click="logout">Выход </a>
                        </b-dropdown-text>
                    </b-dropdown>
                </div>
            </div>
        </div>
        <div class="row wr2">
            <div class="row wr3">
                <div v-show="!showComparison" class="product-wrapper" v-for="(product, index) in products" style="" infinite-wrapper>
                    <a class="product-link" :href="'/products/'+product.id" @mouseenter="hoverProduct(index)" @mouseleave="unHover()">
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
                <infinite-loading @distance="1000" @infinite="infiniteHandler" force-use-infinite-wrapper></infinite-loading>
                <comparison-page v-if="showComparison" :comparison="compareProducts" @closeComparison="closeComparison"></comparison-page>
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
        },
        data() {
            return {
                page: 2,
                favorites: [],
                filterShown: true,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                hoveredIndex : 0,
                showComparison: false,
                productsToCompare: [],
                compareProducts: []
            }
        },
        methods: {
            toggleFilters() {
                this.filterShown = !this.filterShown;
                this.$emit('toggleFilters');
            },
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
            hoverProduct(index) {
                this.hoveredIndex = index + 1;
            },
            unHover() {
                this.hoveredIndex = -1;
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
            },
            toggleProductCompare(id) {
                if(this.productsToCompare.includes(id)) {
                    this.$delete(this.productsToCompare, this.productsToCompare.indexOf(id))
                }
                else {
                    this.productsToCompare.push(id);
                }
                const formData = new FormData();
                this.productsToCompare.forEach(id => {
                    formData.append('products[]', id);
                })
                axios.post('/shop/addProductsToCompare', formData);
            },
            isSetToCompare(id) {
                return this.productsToCompare.includes(id) ? 'set_to_compare' : '';
            },
            productThumbnail(product) {
                if(product.images.length) {
                    return `url(/storage/images/${product.images[0].medium})`
                }
                else {
                    return 'url(/storage/images/products/noimage/noimage_medium.png)'
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
            closeComparison() {
                this.showComparison = false;
            },
            infiniteHandler($state) {
                axios.get('/shop/load?page='+this.page)
                    .then(response => {
                        return response.data;

                    }).then(data => {
                    $.each(data.data, (key, value)=> {
                        this.products.push(value);
                    });
                    $state.loaded();
                });

                this.page = this.page + 1;
            },
        },
        computed: {
            filterBtnCaption() {
                return this.filterShown ? 'Скрыть фильтры' : 'Показать фильтры';
            },
            isGuest() {
                return this.user == null;
            },
        },
        created() {
            this.getUserFavorites();
        }
    }
</script>
<style lang="scss">
    .product-wrapper {
        @media (min-width: 591px) {
            width: 20%; padding: 10px
        }
        @media (max-width: 591px) {
            width: 50%; padding: 10px
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
        .shop-nav {
            padding: 10px 15px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white !important;

            .btn-link .mdi.mdi-account, .mdi-cart{
                font-size: 28px !important;
                color: #ffffff !important;
            }
            button#account-dropdown__BV_toggle_.btn.dropdown-toggle.btn-link.btn-lg {
                padding: 0 !important;
            }
        }
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
        @media (max-width:590px) {
            display: none;
        }
        .show_compare {
            background-color: #868278;;
        }
    }
    #filter-btn-wr {
        #btn-toggle-filters {
            padding: 0 15px 0 5px;
            .mdi {
                margin-right: 5px;
            }
            @media (max-width:590px) {
                width: 100%;
                justify-content: center;
            }
        }
        @media (max-width:590px) {
            width: 100%;
        }
    }
</style>
