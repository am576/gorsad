<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6">
                <p>Корзина</p>
                <div v-for="(product, id) in products" class="product-details">
                    <i class="remove-product mdi mdi-close mdi-24px" @click="removeProduct(id)"></i>
                    <div>Название: {{product['title']}}</div>
                    <div>Цена: {{product['price']}}</div>
                    <div>Количество: {{product['quantity']}}</div>
                    <div>Фото: <img :src="'/storage/images/' + product['image']" alt=""></div>
                </div>
                <div>Сумма: {{price_total}} грн.</div>
                <div class="text-center">
                    <button class="btn btn-primary btn-lg" @click="goToCheckout">Оформить заказ</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            cart_products: {}
        },
        data() {
            return {
                products: {},
                price_total: 0
            }
        },
        methods: {
            getTotalPrice() {
                axios.get('/cart/totalprice')
                .then(response => {
                    this.price_total = response.data
                })
            },
            removeProduct(id) {
                if(confirm('Действительно удалить товар из корзины?'))
                {
                    axios.get('/cart/removeproduct', {
                        params : {
                            id: id
                        }
                    })
                    .then(response => {
                        if(response.status == 200)
                        {
                            this.$delete(this.products, id)
                            this.getTotalPrice();
                        }
                    })
                }

            },
            goToCheckout() {
                window.location.href = "/cart/checkout"
            }
        },
        created() {
            this.products = this.cart_products;
            this.getTotalPrice();
        }
    }
</script>

<style lang="scss" scoped>
    .product-details {
        position: relative;
        border: 1px solid;
        margin: 20px;
        border-radius: 10px;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.42);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.42);
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.42);
    }

    .remove-product {
        position: absolute;
        cursor: pointer;
        top: 0;
        right: 10px;
        color: #000;
    }
</style>
