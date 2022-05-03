<template>
    <g-modal id="modal-cart" ref="cartModal" class="shopping-cart">
        <template v-slot:header>
            <header class="modal-header align-items-center justify-content-md-between justify-content-start">
                <div class="col-md-4 col-4" v-if="showCheckout">
                    <i class="mdi mdi-chevron-left mdi-36px text-black-50 curpointer"  @click="goToCart" />
                </div>
                <div class="col-md-5 col-4 text-center">
                    <h4 class="modal-title justify-content-start">
                        <i class="mdi mdi-cart mdi-36px text-black-50" v-if="!showCheckout"/>
                        {{modalTitle}}
                    </h4>
                </div>
                <div class="col-md-4 col-8 text-right" v-show="!isCartEmpty && !showCheckout">
                    <button  class="checkout-btn btn btn-primary btn-lg" @click="goToCheckout">Оформить заказ</button>
                </div>
            </header>
        </template>
        <div class="container-fluid">
            <div class="row justify-content-center" v-if="!showCheckout">
                <div v-if="!isCartEmpty" class="col-12 order-details">
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
                        <div class="col-lg-10 col-md-12 col-12">
                            <div class="row align-items-center">
                                <div class="col-10 d-flex align-items-center">
                                    <a class="product-link mr-4" :href="'/products/' + id" target="_blank"><strong class="product-title">{{product['title']}}</strong></a>
                                    <span class="remove-product mdi mdi-close mdi-24px" @click="removeProduct(id)"></span>
                                </div>
                                <div class="col-2">

                                </div>
                            </div>
                            <div class="row variant-row" v-for="(variant, index) in product.variants">
                                <div class="col-sm-5 col-8">
                                    {{variantTitle(variant)}}
                                </div>
                                <div class="col-3 d-flex justify-content-between">
                                    <div class="variant-quantity d-flex align-items-center w-50 justify-content-between">
                                        <i class="mdi mdi-minus-circle mdi-24px" @click="changeQuantity(id, index, Number(variant.quantity)-1)"></i>
                                        <span>{{variant.quantity}}</span>
                                        <i class="mdi mdi-plus-circle mdi-24px" @click="changeQuantity(id, index, Number(variant.quantity)+1)"></i>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-12 d-flex justify-content-between align-items-center">
                                    {{variant.price * variant.quantity}} &#8381
                                    <span class="remove-product-variant mdi mdi-trash-can-outline mdi-24px" @click="removeProductVariant(id, index)"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total-price text-center">
                        Сумма: {{totalPrice}} &#8381;
                    </div>
                </div>
                <div v-else>
                    <h3>Ваша корзина пуста</h3>
                </div>
            </div>
            <checkout-page v-if="showCheckout" :order_products="products"></checkout-page>
        </div>
    </g-modal>
</template>

<script>
    export default {
        data() {
            return {
                products: {},
                options: [],
                selectedOption: {},
                showCheckout: false,
            }
        },
        methods: {
            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.search(search, loading, this);
                }
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
                        if(Object.keys(this.products[product_id]['variants']).length === 0)
                        {
                            this.$delete(this.products, product_id);
                            this.removeProduct(product_id);
                        }
                    }
                })
            },
            changeQuantity(id, variant_id, quantity) {
                axios.get('/cart/changequantity', {
                    params: {
                        product_id: id,
                        variant_id: variant_id,
                        quantity: quantity
                    }
                }).then(res => {
                    this.products[id].variants[variant_id].quantity = quantity;
                    this.calcProductPrice(id);
                })
            },
            getCartContents() {
                axios.get('/cart/getCart').then(response => {
                    this.products = response.data.products || [];
                    Object.keys(this.products).forEach(id => {
                        this.calcProductPrice(id);
                    })
                })
            },
            calcProductPrice(id) {
                this.products[id].price = 0;
                Object.values(this.products[id].variants).forEach(variant => {
                    this.products[id].price += variant.price * variant.quantity
                })
            },
            showModal() {
                this.getCartContents();
                this.goToCart();
                this.$refs.cartModal.setModalVisibility(true);
            },
            goToCheckout() {
                // this.putBonuses();
                axios.post('/cart/usebonuses', {
                    amount: this.bonusesToUseAmount
                }).then(response => {
                    this.showCheckout = true;
                })
                .catch(error => {
                    alert('Недостаточно баллов')
                })
            },
            goToCart() {
              this.showCheckout = false;
            },
            variantTitle(variant) {
                const variant_title = variant.height ? variant.height.split(',') : variant.width.split(',');
                const variant_type = variant.height ? 'Высота' : 'Обхват';
                return `${variant.type.replace(/\b\w/g, l => l.toUpperCase())} ${variant_type} ${variant_title[0]} - ${variant_title[1]} см.`
            },
            calcBonusesPrice(e) {
                if(isNaN(this.bonusesToUseAmount)) {
                    this.bonusesToUseAmount = 0;
                }
                else {

                    return (Math.floor(this.bonusesToUseAmount / 10));
                }
            },
            putBonuses() {
                axios.post('/cart/usebonuses', {
                    amount: this.bonusesToUseAmount
                })
            },

        },
        computed: {
            totalPrice() {
                let price = 0;
                Object.values(this.products).forEach(product => {
                    price += product.price;
                })

                return price;
            },
            totalBonuses() {
                let bonuses = 0;
                Object.keys(this.products).forEach(key => {
                    this.products[key]['variants'].forEach(variant => {
                        bonuses+= (variant.bonus * variant.quantity);
                    })
                })

                return bonuses;
            },
            isCartEmpty() {
              return Object.keys(this.products).length === 0
            },
            modalTitle() {
                return this.showCheckout ? 'Подтверждение заказа' : 'Корзина';
            }
        },
        created() {
            this.getCartContents();
            this.$eventBus.$on('showCart', () => {
                this.showModal();
            })
        },
    }
</script>

<style lang="scss" scoped>
    .order-details {
        height: 60vh;
        overflow: scroll;
        padding: 15px 15px 0 15px !important;

        img {
            width: 100px;
            height: 100px;
        }
    }
    .product-row {
        padding: 10px 20px;
        background: #e4e8e9;
        margin-bottom: 1rem;

        a.product-link {
            .product-title {
                font-size: 20px;
            }
            &:hover {
                text-decoration: none;
            }
        }
    }
    .variant-row {
        align-items: center;
        margin-bottom: 2vh;
        background: #e1e3e3;
        .variant-quantity {
            i {
                cursor: pointer;
            }
        }
    }
    .remove-product {
        cursor: pointer;
        color: #888484;
    }
    .remove-product-variant {
        cursor: pointer;
        &:hover {
            color: #1a9aef;
        }
    }
    .total-price {
        font-size: 2rem !important;
        font-weight: bold;
        padding: 20px;
    }

    .back_btn {
        margin-left: 20px;
    }
    .checkout-btn {
        @media (max-width: 900px) {
            font-size: 1rem;
        }
    }
</style>
