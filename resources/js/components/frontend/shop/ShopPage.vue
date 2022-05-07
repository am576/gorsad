<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-1" v-if="!isMobileView">
                <a href="/"><img src="storage/images/logo/shop-logo.png" alt="">
                </a>
            </div>
            <div class="header-mobile" v-if="isMobileView">
                <a class="home-link" href="/"><img src="storage/images/logo/shop-logo.png" alt="">
                    <span class="logo-text">GORSAD</span>
                </a>
                <div class="d-flex align-items-center" v-if="!isGuest">
                    <a class="nav-link curpointer" @click="showCart">
                        <span class="mdi mdi-cart"></span>
                    </a>
                    <account-dropdown :user="user"></account-dropdown>
                </div>
            </div>
            <div class="col-md-10 shop-content">
                <div class="pt-3">
                    <transition name="filter-slide">
                        <shop-filter v-if="showFilters" :attributes_groups="attributes" :filtered_name="filtered_name" :selected_options="filter_options || {}" @filterProducts="filterProducts"></shop-filter>
                    </transition>
                    <shop-navigation :user="user" :isMobileView="isMobileView">
                        <template slot="back_btn" >
                            <div id="filter-btn-wr" :class="{'visibility-hidden' : showComparison}">
                                <button class="nav-btn" id="btn-toggle-filters" @click="toggleFilters">
                                    <i class="mdi mdi-24px" v-bind:class="showFilters ? 'mdi-chevron-up' : 'mdi-chevron-down'"></i>
                                    {{filterBtnCaption}}
                                </button>
                            </div>
                        </template>
                        <template slot="additional_buttons" v-if="productsToCompare.length > 1">
                            <button class="nav-btn show_compare mr-4" @click="toggleComparisonPage">
                                <i class="mdi mdi-24px mdi-format-horizontal-align-center mr-1 mr-l1"></i>
                                Показать сравнение
                            </button>
                        </template>
                    </shop-navigation>
                    <products-list v-show="!showComparison" :products="products" :productsToCompare="productsToCompare" :cart="cart" :user="user" @toggleFilters="toggleFilters" :hasFilterOptions="hasFilterOptions"></products-list>
                    <comparison-page v-if="showComparison" :comparison="compareProducts" @closeComparison="closeComparison"></comparison-page>
                </div>
            </div>
            <div class="col-1"></div>
        </div>
        <shopping-cart></shopping-cart>
    </div>
</template>

<script>
    export default {
        props: {
            products_all: {
                type: Array
            },
            attributes: {
                type: Array,
            },
            user: {
                type: Object
            },
            filter_options: {
                type: Object
            },
            filtered_name: {
                type: String,
                default: ''
            },
            cart: {}
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                products: [],
                showFilters : true,
                isMobileView: false,
                showComparison: false,
                productsToCompare: [],
                compareProducts: [],
                hasFilterOptions: false
            }
        },
        methods: {
            filterProducts(products, filter_options) {
                this.products = 'data' in products ? products.data : products;
                if(Object.keys(filter_options).length > 0) {
                    this.hasFilterOptions = true;
                }
                else {
                    this.hasFilterOptions = false;
                    this.$eventBus.$emit('resetLoader')
                }

            },
            toggleFilters() {
                this.showFilters = !this.showFilters;
            },
            handleView() {
                this.isMobileView = window.innerWidth <= 600;
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
            getComparison() {
                axios.get('/shop/comparison')
                    .then(response => {
                        if(response.data) {
                            this.productsToCompare = [];
                            this.compareProducts = response.data;
                            this.compareProducts.products.forEach(product => {
                                this.productsToCompare.push(product.id)
                            })
                        }
                    })
            },
            toggleComparisonPage() {
                this.toggleFilters();
                this.getComparison();
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
                this.getComparison();
                this.showComparison = false;
            },
            toggleProductCompare(id) {
                if(this.productsToCompare.includes(id)) {
                    this.$delete(this.productsToCompare, this.productsToCompare.indexOf(id));
                }
                else {
                    if(this.productsToCompare.length < 5) {
                        this.productsToCompare.push(id);
                    }
                    else {
                        return;
                    }
                }
                const formData = new FormData();
                this.productsToCompare.forEach(id => {
                    formData.append('products[]', id);
                })
                axios.post('/shop/compare/add', formData);
            },

        },
        computed: {
            isGuest() {
                return this.user == null;
            },
            filterBtnCaption() {
                return this.showFilters ? 'Скрыть фильтры' : 'Показать фильтры';
            },
        },
        created() {
            this.products = 'data' in this.products_all ? this.products_all.data : this.products_all;
            this.handleView();
            this.getComparison();
            this.$eventBus.$on('toggleProductCompare', this.toggleProductCompare);

        }
    }
</script>
<style lang="scss" scoped>
    $header-height : 6vh;
    @media (max-width: 600px) {
        .shop-content {
            margin-top: $header-height;
        }
    }
    .filter-slide-leave-active,
    .filter-slide-enter-active {
        transition: margin-top 300ms linear;
    }
    .filter-slide-enter, .filter-slide-leave-to {
        margin-top: -300px;
    }

    .header-mobile {
        position: fixed;
        background: rgba(7, 19, 8, 0.79);
        z-index: 1000;
        height: $header-height;
        width: 100%;
        display: flex;
        justify-content: space-between;
        img {
            height: $header-height;
        }
        .mdi-account, .mdi-cart{
            font-size: 28px !important;
            color: #ffffff !important;
        }
        a.home-link {
            color: #b5b4b4 !important;
            display: flex;
            align-items: center;
            &:hover {
                text-decoration: none;
            }
        }
        .logo-text {
            font-size: 2.5vh;
            font-weight: bold;
            margin-left: 1vh;
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
            justify-content: center;
        }
    }
</style>
