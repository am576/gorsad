<template>
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
                <td>{{product.title}}</td>
                <td>{{product.code}}</td>
                <td>{{product.category.title}}</td>
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
</template>

<script>
    export default {
        props: {
          products: {},
        },
    }
</script>
