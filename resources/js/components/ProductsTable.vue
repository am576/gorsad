<template>
    <div>
        <table-filter :filter_fields="filter_fields" @filter="filterTable"></table-filter>
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
                    <td :class="colorStatus(product.status)">{{statuses[product.status]}}</td>
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
          products_data: {},
        },
        data() {
          return {
              products: this.products_data,
              filter_fields: [
                  {
                      name: 'title',
                      title: 'Название',
                      type:  'input'
                  },
                  {
                      name:  'code',
                      title: 'Код товара',
                      type:  'input'
                  },
                  {
                      name: 'status',
                      title: 'Статус',
                      type:  'select',
                      options:
                      [
                          {
                              label: 'Активный',
                              value: 1
                          },
                          {
                              label: 'Неактивный',
                              value: 0
                          }
                      ]
                  },
              ],
              statuses: ['Неактивный', 'Активный']
          }
        },
        methods: {
            filterTable(filter_data) {
                axios.post('/api/filterProducts', filter_data
                ).then(response => {
                    this.products = response.data;
                })
            },
            colorStatus(status) {
                return {
                    'text-danger': !status,
                    'text-success': status
                }
            }
        },
        computed: {
            filterProducts(products) {
                this.products =  products
            },

        }
    }
</script>
