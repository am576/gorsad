<template>
    <div>
        <form>
            <div class="form-row">
                <div class="col-auto">
                    <label class="sr-only" for="title">Название</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Название" @keyup="test($event.target.value)">
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="title">Код товара</label>
                    <input type="text" class="form-control" id="code" name="code" placeholder="Код товара" @keyup="test($event.target.value)">
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table id="dataTable" class="table table-hover">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Код товара</th>
                    <th>Категория</th>
                    <th>Цена</th>
                    <th>Скидка</th>
                    <th>Количество</th>
                    <th>Статус</th>
                    <th>Добавлен</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, index) in products" :key="index">
                    <td>{{product.title }}</td>
                    <td>{{product.code}}</td>
                    <td>{{product.category.title}}</td><!---->
                    <td>{{product.price}}</td>
                    <td>{{product.discount}}</td>
                    <td>{{product.quantity}}</td>
                    <td>status</td>
                    <td>{{product.created_at}}</td>
                    <td>
                        buttons
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
          prop_products: {},
        },
        data() {
          return {
              products: this.prop_products,
              filter_fields: []
          }
        },
        methods: {
            test(msg) {
                axios.get('/api/filterProducts', {
                    params: {
                        'title': msg
                    }
                }).then(response => {
                    this.products =  response.data
                })
            }
        },
        computed: {
            filterProducts(products) {
                this.products =  products
            }
        }
    }
</script>
