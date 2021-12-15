<template>
    <b-modal id="modal-cart" size="lg" :title-html="modalTitle" hide-footer>
        <div class="container-fluid">
            <div class="row justify-content-center" v-if="!showCheckout">
                <div v-if="!isCartEmpty" class="col-12 order-details">
                    <h3>Обзор заказа</h3>
                    <!--<v-select :options="options" label="title" @search="onSearch" v-model="selectedOption" :filterable="false" @search:blur="clearSearch" @option:selected="addProduct">
                        <template slot="no-options">
                            быстрый поиск растений...
                        </template>
                        <template slot="option" slot-scope="option">
                            <div class="d-flex justify-content-between">
                                <p>{{ option.title }}</p>
                                <p>{{ option.price }} &#8381</p>
                            </div>
                        </template>
                        <template slot="selected-option" slot-scope="option">
                            <div class="selected d-center">
                                {{ option.title }}
                            </div>
                        </template>
                    </v-select>-->

                    <div class="product-row row align-items-center" v-for="(product, id) in products">
                        <div class="col-2">
                            <img :src="'/storage/images/' + product['image']" alt="">
                        </div>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-10">
                                    <a class="product-link" :href="'/products/' + id" target="_blank"><strong>{{product['title']}}</strong></a>
                                </div>
                                <div class="col-2">
                                    <span class="remove-product mdi mdi-close-circle mdi-24px text-danger" @click="removeProduct(id)"></span>
                                </div>
                            </div>
                            <div class="row" v-for="(variant, index) in product.variants">
                                <div class="col-3">
                                    {{variantTitle(variant)}}
                                </div>
                                <div class="col-3 d-flex">
                                    <input type="number" min="1" oninput="validity.valid||(value='1');" class="form-control" v-model="variant.quantity" @change="changeQuantity(id, index, variant.quantity)">
                                    <span class="remove-product-variant mdi mdi-trash-can-outline mdi-24px" @click="removeProductVariant(id, index)"></span>
                                </div>
                                <div class="col-3">
                                    {{variant.price * variant.quantity}} &#8381
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-price row">
                        Сумма: {{totalPrice}} &#8381;
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary btn-lg" @click="goToCheckout">Оформить заказ</button>
                    </div>
                </div>
                <div v-else>
                    <h3>Ваша корзина пуста</h3>
                </div>
            </div>
            <checkout-page v-if="showCheckout" :order_products="products" @goToCart="goToCart"></checkout-page>
        </div>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                products: {},
                options: [],
                selectedOption: {},
                showCheckout: false
            }
        },
        methods: {
            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.search(search, loading, this);
                }
            },
            search(search, loading, vm)  {
                axios({
                    method: 'GET',
                    url:`/api/searchProduct`,
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded'
                    },
                    params: {
                        q: search
                    }})
                    .then(res => {
                        this.options = res.data;
                        loading(false);
                    })
            },
            clearSearch() {
                this.options = [];
            },
            addProduct(){
                axios.get('/cart/add', {
                    params: {
                        'product_id': this.selectedOption.id
                    }
                })
                    .then(response => {
                        if(response.status == 200)
                        {
                            axios.get('/cart/getCart')
                            .then(response => {
                                this.products = response.data;
                            })
                        }
                    })
            },
            removeProduct(id) {
                axios.get('/cart/removeproduct', {
                    params : {
                        id: id
                    }
                })
                .then(response => {
                    if(response.status == 200)
                    {
                        this.$delete(this.products, id)
                    }
                })
            },
            removeProductVariant(product_id, variant_index) {
                axios.get('/cart/removeproductvariant', {
                    params : {
                        product_id: product_id,
                        variant_index: variant_index
                    }
                })
                .then(response => {
                    if(response.status == 200)
                    {
                        this.$delete(this.products[product_id]['variants'], variant_index);
                        if(this.products[product_id]['variants'].length === 0)
                        {
                            this.$delete(this.products, product_id);
                            this.removeProduct(product_id);
                        }
                    }
                })
            },
            productPrice(id) {
                let price = 0;
                this.products[id].variants.forEach(variant => {
                    this.products[id].price += (variant.price * variant.quantity);
                })

                return this.products[id].price;
            },
            changeQuantity(id, variant_index, quantity) {
                quantity = quantity === '' ? 1 : quantity;
                axios.get('/cart/changequantity', {
                    params : {
                        product_id: id,
                        variant_index: variant_index,
                        quantity: quantity
                    }
                }).then(res => {
                    this.products[id].price = 0;
                    this.products[id].variants.forEach(variant => {
                        this.products[id].price += variant.price * variant.quantity
                    })
                })
            },
            getCartContents() {
                axios.get('/cart/getCart').then(response => {
                    this.products = response.data;
                })
            },
            showModal() {
                this.getCartContents();
                this.$bvModal.show('modal-cart');
            },
            goToCheckout() {
                this.showCheckout = true;
            },
            goToCart() {
              this.showCheckout = false;
            },
            variantTitle(variant) {
                const height = variant.height.split(',');
                return `${variant.type.replace(/\b\w/g, l => l.toUpperCase())} ${height[0]} - ${height[1]} м.`
            }
        },
        computed: {
            totalPrice() {
              let price = 0;
              Object.keys(this.products).forEach(key => {
                  price += this.products[key]['price']
              })

              return price;
            },
            isCartEmpty() {
              return Object.keys(this.products).length === 0
            },
            modalTitle() {
                let title = '<span class=\'mdi mdi-36px mdi-cart\'></span> '
                if(!this.showCheckout) {
                    return  title + 'Корзина';
                }
                else {
                    return title + 'Подтверждение заказа';
                }
            }
        },
        created() {
            this.getCartContents();
            this.$eventBus.$on('showCart', () => {
                this.showModal();
            })
        },
        mounted() {
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                this.showCheckout = false;
            })
        }
    }
</script>

<style lang="scss" scoped>
    .order-details {
        padding: 15px;
    }
    .product-row {
        padding: 10px 20px;
        border-top: 1px solid #ececec;
        margin-bottom: 20px;

        a.product-link {
            &:hover {
                text-decoration: none;
            }
        }
    }

    .remove-product {
        cursor: pointer;
    }

    .remove-product-variant {
        cursor: pointer;
        &:hover {
            color: #1a9aef;
        }
    }
    .total-price {
        font-size: 22px;
        font-weight: bold;
        padding: 0 20px;
        margin-top: 40px;
        margin-bottom: 40px;
    }

    .back_btn {
        margin-left: 20px;
    }
</style>
