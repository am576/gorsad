<template>
    <div class="accordion" role="tablist">
        <!--<b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block v-b-toggle.accordion-1 variant="light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Мои компании</span> <span class="mdi mdi-chevron-down mdi-24px"></span>
                    </div>
                </b-button>
            </b-card-header>
            <b-collapse id="accordion-1"  accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-card style="margin-bottom: 25px;">
                        <b-card-body class="d-flex">
                            <div class="w-50" style="padding-right: 50px;">
                                <b-card-text class="strong-card-text"><strong>Добавьте свою компанию</strong></b-card-text>
                                <b-card-text class="card-description-text">Укажите ИНН организации, которая будет платить за заказ</b-card-text>
                                <b-form-input placeholder="ИНН организации"></b-form-input>
                            </div>
                            <div class="w-50">
                                <div class="d-flex" style="margin-bottom: 20px;">
                                    <div style="padding: 0 10px;">
                                        <span class="mdi mdi-numeric-1-circle mdi-36px text-primary"></span>
                                    </div>
                                    <div>
                                        <b-card-text style="margin-bottom: 5px;">
                                            <strong>Выбирайте товары и оплачивайте заказ</strong>
                                        </b-card-text>
                                        <b-card-text class="card-description-text">
                                            Банковской картой или через расчетный счет
                                        </b-card-text>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div style="padding: 0 10px;">
                                        <span class="mdi mdi-numeric-2-circle mdi-36px text-primary"></span>
                                    </div>
                                    <div>
                                        <b-card-text style="margin-bottom: 5px;">
                                            <strong>Получайте сопроводительные документы</strong>
                                        </b-card-text>
                                        <b-card-text class="card-description-text">
                                            Счёт-договор и УПД
                                        </b-card-text>
                                    </div>
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                    <b-card class="w-50">
                        <b-card-text><strong>{{user.companies[0].name}}</strong></b-card-text>
                        <b-card-text>ИНН: {{user.companies[0].inn}} КПП: {{user.companies[0].kpp}}</b-card-text>
                        <b-card-text>{{user.companies[0].address}}</b-card-text>
                    </b-card>
                </b-card-body>
            </b-collapse>
        </b-card>-->

        <!--<b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block v-b-toggle.accordion-2 variant="light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Сохранённые карты</span> <span class="mdi mdi-chevron-down mdi-24px"></span>
                    </div>
                </b-button>
            </b-card-header>
            <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-card-text>Вы ещё не совершали покупок с помощью платёжных карт.</b-card-text>
                </b-card-body>
            </b-collapse>
        </b-card>-->

        <!--<b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block v-b-toggle.accordion-3 variant="light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Мои отзывы</span> <span class="mdi mdi-chevron-down mdi-24px"></span>
                    </div>
                </b-button>
            </b-card-header>
            <b-collapse id="accordion-3" visible accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-card-text v-if="user.suggested_products.length" style="margin-bottom: 5px;">
                        <h3>{{user.suggested_products.length}} товара ожидают оценки</h3>
                        Оставьте отзыв, чтобы помочь другим покупателям сделать выбор
                    </b-card-text>
                    <b-card-text>

                        <div class="row mt-3">
                            <div v-for="product in user.suggested_products" class="suggested-product col-4 mr-3">
                                <div class="d-flex justify-content-around align-items-center" @click="showReviewForm(product.id)" style="cursor:pointer;">
                                    <img :src="'/storage/images/' + product.images[0].icon">
                                    <p><strong>{{product.title}}</strong></p>
                                    <review-form :modal_id="'product_modal-'+product.id" :product="product"></review-form>
                                </div>
                                <a href="" @click.prevent="doNotReview(product)">Не оставлять отзыв</a>
                            </div>
                        </div>
                    </b-card-text>
                </b-card-body>
            </b-collapse>
        </b-card>-->
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
            showReviewForm(product_id) {
                this.$bvModal.show('product_modal-'+product_id)
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
</style>
