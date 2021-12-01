<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-1">
                <a href="/"><img src="storage/images/logo/shop-logo.png" alt=""></a>
            </div>
            <div class="col-md-10">
                <div class="pt-3">
                    <transition name="filter-slide">
                        <shop-filter v-if="showFilters" :attributes_groups="attributes" :filtered_name="filtered_name" :selected_options="filter_options" @filterProducts="filterProducts"></shop-filter>
                    </transition>
                    <products-list :products="products" :user="user" @toggleFilters="toggleFilters"></products-list>
                </div>
            </div>
            <div class="col-1"></div>

        </div>
    </div>
</template>
<style lang="scss" scoped>
    .filter-slide-leave-active,
    .filter-slide-enter-active {
        transition: margin-top 300ms linear;
    }
    .filter-slide-enter, .filter-slide-leave-to {
        margin-top: -300px;
    }
</style>
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
            filtered_name: ''
        },
        data() {
            return {
                products: [],
                showFilters : true
            }
        },
        methods: {
            filterProducts(products) {
                this.products = products
            },
            toggleFilters() {
                this.showFilters = !this.showFilters;
            }
        },
        created() {
            this.products = this.products_all;
        }
    }
</script>
