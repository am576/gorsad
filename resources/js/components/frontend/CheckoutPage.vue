<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6">
                <h3>Оформление заказа</h3>
                <div class="client-details">
                    <h4>Контактные данные</h4>
                    <div class="form-group">
                        <label>Имя</label>
                        <input type="text" class="form-text" v-model="client.name">
                    </div>
                    <div class="form-group">
                        <label>Телефон</label>
                        <input type="text" class="form-text" v-model="client.phone">
                    </div>
                </div>
                <h4>Сумма: {{price_total}} грн.</h4>
                <h4>Товары</h4>
                <div class="products">
                        <div v-for="(product, id) in products" class="product-details">
                        <div>Название: {{product['title']}}</div>
                        <div>Цена: {{product['price']}}</div>
                        <div>Количество: {{product['quantity']}}</div>
                        <div>Фото: <img :src="'/storage/images/' + product['image']" alt=""></div>
                    </div>
                    <div>Сумма: {{price_total}} грн.</div>
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
                    order_data['products'].push(key)
                });

                order_data['client'] = this.client;
                order_data['sum_total'] = this.price_total;


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
