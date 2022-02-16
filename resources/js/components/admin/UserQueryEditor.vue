<template>
    <div class="container">
        <div class="row w-100 justify-content-between">
            <div class="col-4">Название</div>
            <div class="col-4">Цена</div>
            <div class="col-4">Количество</div>
        </div>
        <div class="row" v-for="(product,index) in products" :key="index">
            <div class="w-100">
                <p v-show="!product.edit" class="product-title">
                    <span class="d-inline-block mr-2">{{product.title}}</span>
                    <span class="mdi mdi-lead-pencil mdi-24px text-primary" @click="editProductName($event.target, index)"></span>
                </p>
                <input v-show="product.edit" type="text" :ref="'custom_name'+index" v-model="product.custom_name" @blur="hideCustomNameInput(index)" @keyup.enter="hideCustomNameInput(index)">
            </div>
            <div class="row w-100" v-for="variant in product.variants">
                <div class="col-4">{{variant.type}}</div>
                <div class="col-4">
                    <input type="number" oninput="validity.valid||(value='1');" class="form-control w-25 d-inline-block" v-model="variant.price"> &#8381;
                </div>
                <div class="col-4">
                    <input type="number" min="1" oninput="validity.valid||(value='1');" class="form-control w-25" v-model="variant.quantity">
                </div>
            </div>
        </div>

        <h4>Сумма: {{totalPrice()}} &#8381;</h4>
        <h4 v-if="query.bonuses">Сумма с учётом баллов: <b>{{priceWithBonuses}} &#8381;</b></h4>
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
                    let price = 0;
                    product.variants.forEach(variant => {
                        price += variant.price * variant.quantity;
                    })
                    total_price += price;
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
        computed: {
            priceWithBonuses() {
                return this.totalPrice() - Math.floor(this.query.bonuses / 10);
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
