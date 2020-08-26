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
                <div>
                    <h4>Доставка</h4>
                    <select v-model="delivery">
                        <option value="1">Кнопочка</option>
                        <option value="2">Карандаш</option>
                        <option value="3">Дижон</option>
                    </select>
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
                delivery: 1,
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
                const formData = new FormData();
                console.log(this.client.name)
                formData.append('client_name', this.client.name);
                formData.append('client_phone', this.client.phone);
                formData.append('sum_total', this.price_total);
                formData.append('delivery', this.delivery);

                Object.keys(this.products).forEach(key => {
                    formData.append(key, this.products[key])
                });

                axios.post('/cart/checkout', formData)
                .then(response => {
                    console.log(response);
                    if(response.status == 200)
                    {
                        window.location.href = "/"
                    }
                })
                .catch(error => {
                    console.log(error.response);
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
