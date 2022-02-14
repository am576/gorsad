<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <button class="btn btn-primary back-btn" @click="goToCart">Назад</button>
                <div class="products">
                    <div v-for="(product, id) in products" class="product-details">
                        <div class="mt-1 mb-2"><strong>{{product['title']}}</strong></div>
                        <div class="row">
                            <div class="col-3">
                                <img :src="'/storage/images/' + product['image']" alt="">

                            </div>
                            <div class="col-9 d-flex flex-column">
                                <div class="row" v-for="(variant, index) in product.variants">
                                    <div class="col-3">
                                        {{variantTitle(variant)}}
                                    </div>
                                    <div class="col-3 d-flex">
                                        {{variant.quantity}} шт.
                                    </div>
                                    <div class="col-3">
                                        {{variant.price * variant.quantity}} &#8381
                                    </div>
                                </div>
                                <div class="mt-2"><strong>Сумма: {{product['price']}}</strong></div>
                            </div>
                        </div>
                    </div>
                    <h5 v-if="bonuses > 0">Использовано баллов: {{bonuses}}</h5>
                    <h4 v-if="bonuses === 0" class="total-price">Всего: {{price_total}} &#8381</h4>
                    <h4 v-else class="total-price">Всего: <s>{{price_total}}</s> {{bonus_price}} &#8381</h4>
                </div>
                <div class="text-center mb-2">
                    <button class="btn btn-primary btn-lg" @click="doCheckout">Подтвердить заказ</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            order_products: {},
            bonuses: 0,
        },
        data() {
            return {
                products: {},
                price_total: 0,
                bonus_price: 0
            }
        },
        methods: {
            getTotalPrice() {
                axios.get('/cart/totalprice')
                .then(response => {
                    this.price_total = response.data;
                    this.bonus_price = this.price_total - Math.floor(this.bonuses / 10)
                })
            },
            goToCart() {
                this.$emit('goToCart');
            },
            doCheckout() {
                const order_data = {
                    products: []
                };

                Object.keys(this.products).forEach(key => {
                    order_data['products'].push({
                        'id': key,
                        'quantity': this.products[key].quantity,
                        'variants': this.products[key].variants
                    })
                });

                axios.post('/cart/checkout', order_data)
                .then(response => {
                    if(response.status == 200)
                    {
                        /*alert('Заказ успешно создан');
                        axios.post('/cart/clear')
                        .then(() =>{
                            window.location.href = "/";
                        })*/
                    }
                })
                .catch(error => {
                    alert('Ошибка обработки заказа');
                })
            },
            variantTitle(variant) {
                const height = variant.height.split(',');
                return `${variant.type.replace(/\b\w/g, l => l.toUpperCase())} ${height[0]} - ${height[1]} м.`
            }
        },
        created() {
            this.products = this.order_products;
            this.getTotalPrice();
        },

    }
</script>

<style lang="scss" scoped>
    .products {
        max-height: 500px;
        padding: 20px 10px;
        margin-bottom: 20px;
        overflow-y: auto;
    }
    .product-details {
        padding: 10px;
        margin: 20px 0;
        -webkit-box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.2);
        -moz-box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.2);
        box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.2);
        background-color: #f5deb3;
    }

    .remove-product {
        position: absolute;
        cursor: pointer;
        top: 0;
        right: 10px;
        color: #000;
    }

    .total-price {
        text-align: center;
        font-size: 26px;
        font-weight: bold;
        padding: 0 20px;
        margin-top: 40px;
    }
</style>
