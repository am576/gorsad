<template>
    
    <div>
        <div>CATALOG</div>
        <div class="row">
            <div id="catalog-filter" class="col-3">
                <div v-for="attribute_group in attributes">
                    <h4>{{ attribute_group.group_name }}</h4>
                    <div v-for="attribute in attribute_group.attributes">
                        <button class="btn btn-light btn-block" v-b-toggle="'attribute-' + attribute.id">
                        {{ attribute.name }}
                    </button>
                    <b-collapse :id="'attribute-' + attribute.id">
                        <div v-for="value in attribute.values">
                            <div @click="addFilterOption(attribute.id, value.id)">{{ value.value }}</div>
                        </div>
                    </b-collapse>
                    </div>
                    
                </div>
            </div>
            <div class="product-list col-9">
                <div class="product-card" v-for="product in products" :key="product.id" >
                    <div class="product-thumb" v-bind:style="{'background-image':productThumbnail(product)}">
                    </div>
                    <div class="product-name">
                        {{ product.title }}
                    </div>
                    <div>
                        <button class="btn-green w-100" type="button">Описание</button>
                    </div>
                </div>
            </div>
        </div>
        
        <button @click="loadMore" v-if="products_all.current_page < products_all.last_page">Load More</button>
  </div>
</template>

<script>
    export default {
        props: {
            products_all: {
                type: Object
            },
            attributes: {
                type: Array,
            },
            user: {
                type: Object
            },
            filter_options: {
                type: Object,
                default: {}
            },
            filtered_name: {
                type: String,
                default: ''
            },
            cart: {},
            show_banner: {
                type: Boolean,
                default: true
            }
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
                hasFilterOptions: false,
                filter: {}
            }
        },
        methods: {
            loadProducts(page = 1) {
                axios.get(`/api/products?page=${page}`)
                    .then(response => {
                    if (this.products) {
                        this.products = this.products.concat(response.data.data);
                        this.products_all.current_page += 1
                    } else {
                        this.products = response.data;
                    }
                    })
                    .catch(error => {
                    console.error('Error loading products:', error);
                });
            },
            loadMore() {
                this.loadProducts(this.products_all.current_page + 1);
            },
            productThumbnail(product) {
                if(product.image) {
                    return `url(/storage/images/${product.image.medium})`
                }
            },
            addFilterOption(attr_id, value_id) {
                if (this.filter.hasOwnProperty(attr_id)) {
                    if (this.filter[attr_id].includes(value_id)) {
                        if(this.filter[attr_id].length === 1) {
                            this.$delete(this.filter, attr_id)
                        }
                        else {
                            this.filter[attr_id].splice(this.filter[attr_id].indexOf(value_id), 1)
                        }
                        
                    }
                    else {
                        this.filter[attr_id].push(value_id)
                    }    
                }
                else {
                    this.filter[attr_id] = [value_id]
                }
                
            },
            // addFilterOption(option) {
            //     if(option.values.length) {
            //         this.filter_options[option.attribute] = option.values;
            //     }
            //     else {
            //         this.$delete(this.filter_options, option.attribute);
            //     }

            //     this.doFilterProducts();
            // },
            doFilterProducts() {
                axios.post('/shop/filter', {
                    product_name: this.product_name,
                    filter: this.filter_options
                })
                .then(response => {
                    this.$emit('filterProducts', response.data, this.filter_options)
                })
            },
            filterProducts(products, filter_options) {
                let isFilter = false;
                this.products = 'data' in products ? products.data : products;
                    this.hasFilterOptions = true;
                this.$eventBus.$emit('updateProductsList', this.products, true);
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
            /*getComparison() {
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
            },*/

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
            // this.handleView();
            // this.getComparison();
            // this.$eventBus.$on('toggleProductCompare', this.toggleProductCompare);

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
            @media (max-width:600px) {
                width: 100%;
                justify-content: center;
            }
        }
        @media (max-width:600px) {
            width: 100%;
            justify-content: center;
        }
    }
</style>
