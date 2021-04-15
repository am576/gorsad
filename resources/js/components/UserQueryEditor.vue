<template>
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product,index) in p" :key="index">
                <td>{{product.title}}</td>
                <td>
                    <input type="number" class="form-control w-25 d-inline-block" v-model="product.price"> &#8381;
                </td>
                <td>{{product.quantity}}</td>
            </tr>
            </tbody>
        </table>
        <h3>Сумма: {{totalPrice()}} &#8381;</h3>
        <div class="row justify-content-end">
            <button class="btn btn-primary">Сохранить и отправить</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            products: []
        },
        data() {
            return {
                p: []
            }
        },
        methods:  {
            totalPrice() {
                let total_price = 0;
                this.products.forEach(product => {
                    total_price += product.price * product.quantity;
                })

                return total_price;
            }
        },
        computed: {

        },
        created() {
            this.p = this.products;
        }
    }
</script>
