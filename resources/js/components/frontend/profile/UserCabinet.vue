<template>
    <div class="accordion" role="tablist">
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block v-b-toggle.accordion-1 variant="light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Мои компании</span> <span class="mdi mdi-chevron-down mdi-24px"></span>
                    </div>
                </b-button>
            </b-card-header>
            <b-collapse id="accordion-1" visible accordion="my-accordion" role="tabpanel">
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
                        <b-card-text><strong>{{companies[0].name}}</strong></b-card-text>
                        <b-card-text>ИНН: {{companies[0].inn}} КПП: {{companies[0].kpp}}</b-card-text>
                        <b-card-text>{{companies[0].address}}</b-card-text>
                    </b-card>
                </b-card-body>
            </b-collapse>
        </b-card>

        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block v-b-toggle.accordion-2 variant="light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Сохранённые карты</span> <span class="mdi mdi-chevron-down mdi-24px"></span>
                    </div>
                </b-button>
            </b-card-header>
            <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-card-text>123</b-card-text>
                </b-card-body>
            </b-collapse>
        </b-card>

        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <b-button block v-b-toggle.accordion-3 variant="light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Мои отзывы</span> <span class="mdi mdi-chevron-down mdi-24px"></span>
                    </div>
                </b-button>
            </b-card-header>
            <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-card-text>123</b-card-text>
                </b-card-body>
            </b-collapse>
        </b-card>
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
                companies: {}
            }
        },
        created() {
            this.companies = this.data
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
</style>
