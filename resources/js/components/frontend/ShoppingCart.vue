<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6 order-details">
                <h3>Обзор заказа</h3>
                <v-select :options="options" label="title" @search="onSearch" v-model="selectedOption" :filterable="false" @search:blur="clearSearch" @option:selected="addProduct">
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
                </v-select>
                <div class="product-row row align-items-center" v-for="(product, id) in products">
                    <div class="col-2">
                        <img :src="'/storage/images/' + product['image']" alt="">
                    </div>
                    <div class="col-4">
                        {{product['title']}}
                    </div>
                    <div class="col-3 d-flex align-items-center">
                        <input type="number" min="1" oninput="validity.valid||(value='1');" class="form-control" v-model="product['quantity']" @change="changeQuantity(id, product['quantity'])">
                        <span class="remove-product mdi mdi-trash-can-outline mdi-24px" @click="removeProduct(id)"></span>
                     </div>
                    <div class="col-3">
                        {{product['price'] * product['quantity']}} &#8381;
                    </div>
                </div>
                <div>Сумма: {{totalPrice}} &#8381;</div>
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
                options: [],
                selectedOption: {}
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
                        }
                    })
                }

            },
            changeQuantity(id, quantity) {
                quantity = quantity === '' ? 1 : quantity;
                axios.get('/cart/changequantity', {
                    params : {
                        product_id: id,
                        quantity: quantity
                    }
                })
            },
            goToCheckout() {
                window.location.href = "/cart/checkout"
            }
        },
        computed: {
          totalPrice() {
              let price = 0;
              Object.keys(this.products).forEach(key => {
                  price += this.products[key]['price'] * this.products[key]['quantity']
              })

              return price;
          }
        },
        created() {
            this.products = this.cart_products;
        }
    }
</script>

<style lang="scss" scoped>
    .order-details {
        border: 1px solid #000000;
        padding: 15px;
    }
    .product-row {
        padding: 10px 0;
        border-top: 1px solid #ececec;
    }

    .remove-product {
        cursor: pointer;
        &:hover {
            color: #1a9aef;
        }
    }
</style>
