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
            <tr v-for="(product,index) in products" :key="index">
                <td>
                    <p v-show="!product.edit" class="product-title">
                        <span class="d-inline-block mr-2">{{product.title}}</span>
                        <span class="mdi mdi-lead-pencil mdi-24px text-primary" @click="editProductName($event.target, index)"></span>
                    </p>
                    <input v-show="product.edit" type="text" :ref="'custom_name'+index" v-model="product.custom_name" @blur="hideCustomNameInput(index)" @keyup.enter="hideCustomNameInput(index)">
                </td>
                <td>
                    <input type="number" class="form-control w-25 d-inline-block" v-model="product.price"> &#8381;
                </td>
                <td>
                    <input type="number" min="1" oninput="validity.valid||(value='1');" class="form-control w-25" v-model="product.quantity">
                </td>
            </tr>
            </tbody>
        </table>
        <h3>Сумма: {{totalPrice()}} &#8381;</h3>
        <div class="row justify-content-end">
            <button class="btn btn-primary" @click="submit()">Сохранить и отправить</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            query: {
                type: Object
            },
            data: []
        },
        data() {
            return {
                products: []
            }
        },
        methods:  {
            totalPrice() {
                let total_price = 0;
                this.products.forEach(product => {
                    total_price += product.price * product.quantity;
                })

                return total_price;
            },
            editProductName(el, index) {
                this.$set(this.products[index], 'custom_name', this.products[index].title);
                this.$set(this.products[index], 'edit', true);
                this.$nextTick(() => this.$refs['custom_name'+index][0].focus())
            },
            hideCustomNameInput(index) {
                this.$set(this.products[index], 'title', this.products[index].custom_name);
                this.$set(this.products[index], 'edit', false);
            },
            submit() {
                axios.post(window.location.href + '/approve', {
                        query_id : this.query.id,
                        user_id: this.query.user_id,
                        products: this.products
                })
                .then(res => {
                    window.location.href = '/admin/orders';
                })
            }
        },
        created() {
            this.products = this.data;
        }
    }
</script>
<style lang="scss" scoped>
    .product-title {
        .mdi {
            cursor: pointer;
        }
    }
</style>
