<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6">
                <h3>Оформление заказа</h3>
                <h4>Сумма: {{price_total}} р.</h4>
                <h4>Товары</h4>
                <div class="products">
                    <div v-for="(product, id) in products" class="product-details">
                        <div>Название: {{product['title']}}</div>
                        <div>Цена: {{product['price']}}</div>
                        <div class="row">
                            <div class="col-3">Фото: <img :src="'/storage/images/' + product['image']" alt=""></div>
                            <div class="col-9">
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
                            </div>

                        </div>

                    </div>
                    <div>Сумма: {{price_total}} р.</div>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary btn-lg" @click="doCheckout">Подтвердить заказ</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            order_products: {}
        },
        data() {
            return {
                products: {},
                price_total: 0,
                client: {},
            }
        },
        methods: {
            getTotalPrice() {
                axios.get('/cart/totalprice')
                .then(response => {
                    this.price_total = response.data
                })
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
                        alert('Заказ успешно создан');
                        axios.post('/cart/clear')
                        .then(() =>{
                            window.location.href = "/";
                        })
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
        }
    }
</script>

<style lang="scss" scoped>
    .products {
        max-height: 500px;
        padding: 20px;
        margin-bottom: 20px;
        overflow-y: auto;
        border: 1px solid;
        border-radius: 10px;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.42);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.42);
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.42);
    }
    .client-details, .product-details {
        margin: 20px 0;
        border: 1px solid;
        border-radius: 10px;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.42);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.42);
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.42);
    }

    .client-details {
        padding: 20px;
    }

    .remove-product {
        position: absolute;
        cursor: pointer;
        top: 0;
        right: 10px;
        color: #000;
    }
</style>
