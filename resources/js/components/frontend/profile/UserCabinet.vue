<template>
    <div id="company-accordion" class="accordion">
        <div class="card mb-1">
            <header class="card-header p-1">
                <button class="btn btn-light btn-block" v-b-toggle.accordion-1>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Мои компании</span> <span class="mdi mdi-chevron-down mdi-24px"></span>
                    </div>
                </button>
            </header>
            <b-collapse id="accordion-1">
                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-body d-flex">
                            <div class="w-50">
                                <p class="card-text strong-card-text">
                                    <strong>Добавьте свою компанию</strong>
                                </p>
                                <p class="card-text card-description-text">
                                    Укажите ИНН организации, которая будет платить за заказ
                                </p>
                                <input type="text" class="form-control w-75" placeholder="ИНН организации">
                            </div>
                            <div class="w-50">
                                <div class="d-flex mb-4">
                                    <div class="digit-icon">
                                        <span class="mdi mdi-numeric-1-circle mdi-36px text-primary"></span>
                                    </div>
                                    <div>
                                        <p class="card-text mb-1">
                                            <strong>Выбирайте товары и оплачивайте заказ</strong>
                                        </p>
                                        <p class="card-text card-description-text">
                                            Банковской картой или через расчетный счет
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="digit-icon">
                                        <span class="mdi mdi-numeric-2-circle mdi-36px text-primary"></span>
                                    </div>
                                    <div>
                                        <p class="card-text mb-1">
                                            <strong>Получайте сопроводительные документы</strong>
                                        </p>
                                        <p class="card-text card-description-text">
                                            Счёт-договор и УПД
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card w-50">
                        <div class="card-body">
                            <div class="card-text"><strong>{{user.companies[0].name}}</strong></div>
                            <div class="card-text">ИНН: {{user.companies[0].inn}} КПП: {{user.companies[0].kpp}}</div>
                            <div class="card-text">{{user.companies[0].address}}</div>
                        </div>
                    </div>
                </div>
            </b-collapse>
        </div>
        <div class="card">
            <header class="card-header p-1">
                <button class="btn btn-light btn-block" v-b-toggle.accordion-2>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Сохранённые карты</span> <span class="mdi mdi-chevron-down mdi-24px"></span>
                    </div>
                </button>
            </header>
            <b-collapse id="accordion-2">
                <div class="card-body">
                    <div class="card-text">
                        Вы ещё не совершали покупок с помощью платёжных карт.
                    </div>
                </div>
            </b-collapse>
        </div>
        <div class="card">
            <header class="card-header p-1">
                <button class="btn btn-light btn-block" v-b-toggle.accordion-3>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Мои отзывы</span> <span class="mdi mdi-chevron-down mdi-24px"></span>
                    </div>
                </button>
            </header>
            <b-collapse id="accordion-3">
                <div class="card-body">
                    <div class="card-text mb-1" v-if="user.suggested_products.length">
                        <h3>{{user.suggested_products.length}} товара ожидают оценки</h3>
                        Оставьте отзыв, чтобы помочь другим покупателям сделать выбор
                    </div>
                    <div class="card-text">
                        <div class="row mt-3">
                            <div v-for="(product, index) in user.suggested_products" class="suggested-product col-4 mr-3">
                                <div class="d-flex justify-content-around align-items-center" @click="showReviewForm(product.id, index)" style="cursor:pointer;">
                                    <img :src="'/storage/images/' + productImage(product)">
                                    <p><strong>{{product.title}}</strong></p>
                                </div>
                                <review-form :product="product" ref="reviewForm"></review-form>
                                <a href="" @click.prevent="doNotReview(product)">Не оставлять отзыв</a>
                            </div>
                            <div class="pl-4" v-if="user.suggested_products.length === 0">Пока нет товаров для оценки.</div>
                        </div>
                    </div>
                </div>
            </b-collapse>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: {
                type: Object
            }
        },
        data() {
            return {
                user: {}
            }
        },
        methods: {
            showReviewForm(product_id, index) {
                this.$refs.reviewForm[index].showForm(product_id);
            },
            doNotReview(product) {
                axios.post('/donotreview', {
                    'product_id': product.id
                })
                .then(res => {
                    this.deleteProductFromSuggested(product);
                })
            },
            deleteProductFromSuggested(product) {
                this.$delete(this.user.suggested_products, this.user.suggested_products.indexOf(product));
            },
            productImage(product) {
                return product.images.length > 0 ? product.images[0].icon : 'products/noimage/noimage_icon.png'
            }
        },
        created() {
            this.user = this.data;
            this.$eventBus.$on('postReview', this.deleteProductFromSuggested);
        }
    }
</script>
<style lang="scss" scoped>
    .strong-card-text {
        margin-bottom: 10px !important;
    }

    .card-description-text {
        font-size: 14px !important;
    }

    .suggested-product {
        border-radius: 10px;
        padding: 15px;
        -webkit-box-shadow: 0px 0px 36px 0px rgba(0,0,0,0.35);
        -moz-box-shadow: 0px 0px 36px 0px rgba(0,0,0,0.35);
        box-shadow: 0px 0px 36px 0px rgba(0,0,0,0.35);
    }
    .digit-icon {
        padding: 0 10px;
    }
</style>
