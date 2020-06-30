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
                <tr v-for="(product, index) in products.data" :key="index">
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
            <table-pagination :pagination="products" :offset="4" @paginate="getProducts" @changePerPage="changePerPage">
            </table-pagination>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
              categories: [],
              statuses: ['Неактивный', 'Активный'],
              products: {
                  total: 0,
                  per_page: 2,
                  from: 1,
                  to: 0,
                  current_page: 1
              },
              filter_data: [],
              per_page: 10
          }
        },
        methods: {
            filterTable(filter_data) {
                this.filter_data = filter_data;
                console.log(this.filter_data);
                axios.get('/api/filterProducts', {
                    params: {
                        page: this.products.current_page,
                        filter_data: filter_data,
                        per_page: this.per_page
                    }
                    }
                ).then(response => {
                    this.products = response.data;
                })
            },
            colorStatus(status) {
                return {
                    'text-danger': !status,
                    'text-success': status
                }
            },
            getProducts(page_number) {
                axios.get('/api/filterProducts', {
                        params: {
                            page: page_number,
                            filter_data: this.filter_data,
                            per_page: this.per_page
                        }
                    }
                ).then(response => {
                    if(this.per_page > response.data.total) {
                        if(this.products.current_page !== 1) {
                            this.getProducts(1)
                        }
                    }
                    this.products = response.data;
                })
            },
            changePerPage(per_page) {
                this.per_page = per_page;
                this.getProducts(this.products.current_page);
            },
            getCategories() {
                return axios.get('/api/getAllCategories')
                    .then(response => {
                        return response.data
                    })
            },
            setCategoriesFilter() {
                this.getCategories()
                    .then(categories => {
                        $.each(categories, (index, category) => {
                            this.$set(this.categories, index, {
                                label: category.title,
                                value: category.id
                            })
                        });
                    })
                console.log(this.categories);
            }
        },
        computed: {
            filter_fields() {
                return  [
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
                    {
                        name: 'category_id',
                        title: 'Категория',
                        type: 'select',
                        options: this.categories
                    }
                ]
            }
        },
        created() {
            this.getProducts(this.products.current_page);
            this.setCategoriesFilter()
        }
    }
</script>
