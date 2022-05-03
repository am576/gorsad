<template>
    <div class="row">
        <div class="col-12 checkout-details">
            <div v-for="product in products" class="row product-details">
                <div class="col-2">
                    <img :src="'/storage/images/' + product['image']" style="width: 100px; height: 100px;" alt="">
                </div>
                <div class="col-12 col-md-12 col-lg-10">
                    <div class="row">
                        <div class="col-10">
                            <strong>{{product['title']}}</strong>
                        </div>
                    </div>
                    <div class="row variant-row" v-for="variant in product.variants">
                        <div class="col-6">
                            {{variantTitle(variant)}}
                        </div>
                        <div class="col-3">
                            {{variant.quantity}} шт.
                        </div>
                        <div class="col-3">
                            {{variant.price * variant.quantity}} &#8381
                        </div>
                    </div>
                </div>
                <div class="mt-2"><strong>Сумма: {{product['price']}}</strong></div>
            </div>
        </div>
        <div class="col-12 d-flex flex-wrap mt-3">
            <div class="total-price text-center">
                Сумма: {{price_total}} &#8381;
            </div>
            <div class="confirm-order text-center mb-5">
                <button class="btn btn-primary btn-lg" @click="doCheckout">Подтвердить заказ</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            order_products: {},
        },
        data() {
            return {
                products: {},
                price_total: 0,
            }
        },
        methods: {
            getTotalPrice() {
                axios.get('/cart/totalprice')
                .then(response => {
                    this.price_total = response.data;
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
                const variant_title = variant.height ? variant.height.split(',') : variant.width.split(',');
                const variant_type = variant.height ? 'Высота' : 'Обхват';
                return `${variant.type.replace(/\b\w/g, l => l.toUpperCase())} ${variant_type} ${variant_title[0]} - ${variant_title[1]} см.`
            }
        },
        created() {
            this.products = this.order_products;
            this.getTotalPrice();
        },

    }
</script>

<style lang="scss" scoped>
    .checkout-details {
        height: 40vh;
        overflow-y: auto;

        .variant-row {
            margin-top: 15px;
            background: #fbe4b9;
        }
    }
    .products {
        padding: 20px 0;
        margin-bottom: 10px;
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
        @media (max-height:500px) {
            width: 50%;
        }
        @media (min-height:500px) {
            width: 100%;
            margin-bottom: 20px;
        }
    }
    .confirm-order {
        width: 100%;
        @media (max-height: 500px) {
            width: 50%;
        }
    }
</style>
