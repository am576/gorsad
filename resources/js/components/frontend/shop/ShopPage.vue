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
                    <b-dropdown id="account-dropdown" size="lg" right variant="link" block toggle-class="text-decoration-none" no-caret>
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
            <div class="col-md-10">
                <div class="pt-3">
                    <transition name="filter-slide">
                        <shop-filter v-if="showFilters" :attributes_groups="attributes" :filtered_name="filtered_name" :selected_options="filter_options || ''" @filterProducts="filterProducts"></shop-filter>
                    </transition>
                    <products-list :products="products" :cart="cart" :user="user" @toggleFilters="toggleFilters"></products-list>
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
                type: Array
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
            }
        },
        methods: {
            filterProducts(products) {
                this.products = products
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
            }
        },
        computed: {
            isGuest() {
                return this.user == null;
            },
        },
        created() {
            this.products = this.products_all;
            this.handleView();
        }
    }
</script>
<style lang="scss" scoped>
    .filter-slide-leave-active,
    .filter-slide-enter-active {
        transition: margin-top 300ms linear;
    }
    .filter-slide-enter, .filter-slide-leave-to {
        margin-top: -300px;
    }
    $header-height : 6vh;
    .header-mobile {
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
</style>
