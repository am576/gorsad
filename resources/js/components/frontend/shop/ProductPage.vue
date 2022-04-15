<template>
    <div id="product-page">
        <div class="row justify-content-start m-0">
            <div class="image-wrapper col-lg-6 col-sm-12">
                <div class="display-image" :style="{'background-image':'url(/storage/images/' + product.images[0].large || '' +')'}">
                    <div class="product-name-rus">{{product.title}}</div>
                    <div class="product-name-lat">{{product.title_lat}}</div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12">
                <div class="p-3">
                    <h3>{{product.title}}</h3>
                    <h5 class="text-muted">{{product.title_lat}}</h5>
                    <div>----</div>
                    <div>
                        <p v-html="product.description"></p>
                        <h5>Характеристики</h5>
                        <div class="attr-row row">
                            <div class="col-md-4 col-sm-3">Высота</div>
                            <div class="col-md-8 col-sm-9">{{height[0]}} - {{height[1]}} м.</div>
                        </div>
                        <div class="attr-row row">
                            <div class="col-md-4">Тип почвы</div>
                            <div class="col-md-8">
                                <span class="attr-tag" v-for="attr in soil">{{attr}}</span>
                            </div>
                        </div>
                        <div class="attr-row row">
                            <div class="col-md-4">Скорость роста</div>
                            <div class="col-md-8">{{speed[0]}}</div>
                        </div>
                        <div class="attr-row row" v-if="leaf_color.length">
                            <div class="col-md-4">Цвет листа</div>
                            <div class="col-md-8">
                                <span class="attr-color" v-for="color in leaf_color" v-bind:style="{background: color}"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="divider"></div>
        <nav class="nav-tabs product-variants">
            <b-tabs  horizontal nav-wrapper-class="tabs-wrapper d-flex justify-content-start" active-nav-item-class="tab_active" active-tab-class="tab_active">
                <b-tab title="Штамб(St)" active >
                    <b-table borderless :fields="variants_table_data('st').fields" :items="variants_table_data('st').items" :tbody-tr-class="'table-row'">
                        <template #cell(price)="data">
                            <span v-if="data.item.price > 0">{{data.item.price}}</span>
                        </template>
                        <template #cell(quantity)="data">
                            <input class="quantity-input" type="number" oninput="validity.valid||(value='1');" v-model="quantities[data.item.id]" v-if="data.item.price > 0">
                        </template>
                        <template #cell(buy)="data">
                            <button class="buy-btn" @click="addToCart(data.item.id)" v-if="data.item.price > 0">
                                <span class="mdi mdi-cart-outline mdi-24px"></span>
                            </button>
                            <button style="padding: 10px !important; font-size: 16px;" class="buy-btn" @click="priceRequest(data.item.id)" v-else>
                                Запрос цены
                            </button>
                        </template>
                        <template #cell(bonus)="data">
                            <img height="50" v-if="data.item.bonus.bonus_value > 0" src="/storage/images/public/bonus_icon.png" alt="" :title="'Покупка этого товара принесёт ' + data.item.bonus.bonus_value + ' баллов'">
                        </template>
                    </b-table>
                </b-tab>
                <b-tab title="Мультиштамб(MtSt)">
                    <b-table borderless :fields="variants_table_data('mtst').fields" :items="variants_table_data('mtst').items" :tbody-tr-class="'table-row'">
                        <template #cell(price)="data">
                            <span v-if="data.item.price > 0">{{data.item.price}}</span>
                        </template>
                        <template #cell(quantity)="data">
                            <input class="quantity-input" type="number" oninput="validity.valid||(value='1');" v-model="quantities[data.item.id]" v-if="data.item.price > 0">
                        </template>
                        <template #cell(buy)="data">
                            <button class="buy-btn" @click="addToCart(data.item.id)" v-if="data.item.price > 0">
                                <span class="mdi mdi-cart-outline mdi-24px"></span>
                            </button>
                            <button style="padding: 10px !important; font-size: 16px;" class="buy-btn" @click="priceRequest(data.item.id)" v-else>
                                Запрос цены
                            </button>
                        </template>
                        <template #cell(bonus)="data">
                            <img height="50" v-if="data.item.bonus.bonus_value > 0" src="/storage/images/public/bonus_icon.png" alt="" :title="'Покупка этого товара принесёт ' + data.item.bonus.bonus_value + ' баллов'">
                        </template>
                    </b-table>
                </b-tab>
                <b-tab title="Солитер(Sol)">
                    <b-table borderless :fields="variants_table_data('sol').fields" :items="variants_table_data('sol').items" :tbody-tr-class="'table-row'">
                        <template #cell(price)="data">
                            <span v-if="data.item.price > 0">{{data.item.price}}</span>
                        </template>
                        <template #cell(quantity)="data">
                            <input class="quantity-input" type="number" oninput="validity.valid||(value='1');" v-model="quantities[data.item.id]" v-if="data.item.price > 0">
                        </template>
                        <template #cell(buy)="data">
                            <button class="buy-btn" @click="addToCart(data.item.id)" v-if="data.item.price > 0">
                                <span class="mdi mdi-cart-outline mdi-24px"></span>
                            </button>
                            <button style="padding: 10px !important; font-size: 16px;" class="buy-btn" @click="priceRequest(data.item.id)" v-else>
                                Запрос цены
                            </button>
                        </template>
                        <template #cell(bonus)="data">
                            <img height="50" v-if="data.item.bonus.bonus_value > 0" src="/storage/images/public/bonus_icon.png" alt="" :title="'Покупка этого товара принесёт ' + data.item.bonus.bonus_value + ' баллов'">
                        </template>
                    </b-table>
                </b-tab>
            </b-tabs>
        </nav>
        <div class="d-flex justify-content-center pb-5 mb-4 mt-4">
            <div class="all-specs">
                <div class="specs-header">
                    <h4 class="font-weight-bold">ВСЕ ХАРАКТЕРИСТИКИ</h4>
                </div>
                <div class="row" v-for="attribute in product.attributes">
                    <div class="col-lg-3 col-sm-4 d-flex align-items-center">
                        {{attribute.name}}
                    </div>
                    <div class="col-lg-9 col-sm-8">
                        <div v-if="isTagType(attribute)">
                            <span class="attr-tag" v-for="value in attribute.values">{{value}}</span>
                        </div>
                        <div v-if="attribute.type === 'range'">
                            {{attribute.values[0]}} - {{attribute.values[1]}}
                        </div>
                        <div v-if="attribute.type === 'text' && !isTagType(attribute)">
                            {{attribute.values[0]}}
                        </div>
                        <div v-if="attribute.type === 'color'">
                        <span class="attr-color" v-for="color in attribute.values"
                              v-bind:style="{background: color}">
                        </span>
                        </div>
                        <div v-if="attribute.type === 'icon'" class="d-flex align-items-center">
                            <div class="d-flex align-items-center" v-for="(attr_value, index) in attribute.values">
                                <span>{{attr_value}}</span>
                                <img height="40" :src="'/storage/images/' + attribute.icon[index]" alt="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="user-reviews mt-5">
            <h2>Отзывы</h2>
            <b-card v-for="(review,index) in product.reviews" :key="index" :title="review.user.name" :sub-title="moment(product.created_at).format('DD.MM.YYYY hh:mm')" class="mt-4">
                <b-card-text>Достоинства: {{review.pluses}}</b-card-text>
                <b-card-text>Недостатки: {{review.minuses}}</b-card-text>
                <b-card-text>Комментарий: {{review.comment}}</b-card-text>
            </b-card>
        </div>-->
    </div>
</template>

<script>
    import moment from "moment";
    export default {
        props: {
            product: {},
            height :[],
            soil :[],
            speed :[],
            leaf_color:[]
        },
        data() {
            return {
                moment: moment,
                current_image: '',
                product_attributes: {},
                quantities: {},

            }
        },
        methods: {
            changeQuantity(variant, new_quantity) {
                this.quantities[variant] = new_quantity;
            },
            setCurrentImage(image) {
                this.current_image = image;
            },
            addToCart(variant_id) {
                let quantity = variant_id in this.quantities ? this.quantities[variant_id] : 1;
                axios.get('/cart/add', {
                    params: {
                        'product_id': this.product.id,
                        'variant_id': variant_id,
                        'quantity': quantity
                    }
                })
                .then(response => {
                    if(response.status == 200)
                    {
                        alert('Товар добавлен в корзину');
                    }
                    else
                    {
                        alert('Ошибка');
                    }
                })
            },
            rangeFormatted(value, unit) {
                let ar = value.split(',');
                return `${ar[0]} -  ${ar[1]} ${unit}.`
            },
            variants_table_data(type) {
                const labels = [
                    {key: 'height', 'label': 'Высота'},
                    {key: 'width', 'label': 'Обхват ствола'},
                    {key: 'price', 'label': 'Цена'},
                    {key: 'quantity', 'label': 'Количество'},
                    {key: 'buy', 'label': ''},
                    {key: 'bonus', 'label': ''},
                ];
                let rows = [];

                this.product.variants[type].forEach((variant, index) => {
                    rows.push(
                        {
                            id: variant.id,
                            height: this.rangeFormatted(variant.height, 'м'),
                            width: this.rangeFormatted(variant.width, 'см'),
                            price: variant.price,
                            quantity: 1,
                            buy: variant,
                            bonus: variant
                        }
                    )
                    this.quantities[variant.id] = 0;
                })

                return {
                    fields: labels,
                    items: rows
                }
            },
            isTagType(attribute) {
                return attribute.type === 'text' && attribute.values.length > 1
            },
            priceRequest() {
                alert('Запрос отправлен. Уведомление о цене Вы сможете увидеть в Вашем личном кабинете');
            },
            replaceMissingImages() {
                if(this.product.images.length === 0) {
                   this.product.images.push({
                       large: 'products/noimage/noimage_large.png'
                   })
                }
            }
        },
        created() {
            this.replaceMissingImages();
            this.setCurrentImage(this.product.images[0]);
            this.$set(this.product, 'additional_info', JSON.parse(this.product.additional_info));
        }
    }
</script>

<style lang="scss">
    #product-page {
        background: #434242;
        * {
            color: #e7e7e7 !important;
        }
        input.quantity-input {
            color: #000000 !important;
            text-align: center;
            width: 50%;
        }
        button.buy-btn {
            border: none;
            padding: 0 35px !important;
            background: #4c4b4b;
            border-radius: 2px;
        }
        .divider {
            background: #343434;
            height: 100px;
            width: 100%;
        }
        .product-variants {
            margin-top: -50px;
        }
        .image-wrapper {
            padding: 10px;
            @media (max-width: 590px) {
                padding: 0;
            }
        }
        .display-image {
            min-width: 600px;
            min-height: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;

            @media (max-width: 590px) {
                width: 100vw;
                height: 50vh;
                min-height: 0;
                min-width: 0;
            }

            .product-name-rus {
                font-size: 6.5vh;

                font-weight: bold;
                color: #ffffff !important;
            }
            .product-name-lat {
                font-size: 30px;
                color: #ffffff !important;
            }
        }
        .tabs-wrapper {
            width: 75%;
            @media (max-width: 590px) {
                width: 100%;
            }
        }
        a.tab_active {
            background: #4c4b4b !important;
            border: none !important;
            border-radius: 0 !important;
        }

        .table-row {
            background: #9d9898;
            border-bottom: 20px solid #a9a6a6;
            border-top: 20px solid #a9a6a6;
        }
        .b-table tbody {
            background: #a9a6a6 !important;
        }
        td, th {
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            font-size: 2.1vh;
        }
        th {
            padding: 1rem 0.25rem;
        }
        td {
            padding: 0.25rem;
        }
        th:not(:last-child){
            width: 20%;
        }

        .nav-tabs {
            border-bottom: none !important;
            a.nav-link {
                font-size: 2.25vh;
                font-weight: bold;
                border: none !important;
                color: #e7e7e7 !important;
                &:hover {
                    color: #e7e7e7 !important;
                    border: none !important;
                }
            }
        }

        ul.nav-tabs {
            border: none !important;
        }
        .all-specs {
            width: 60%;
            @media (max-width: 590px) {
                width: 90%;
                .specs-header {
                    text-align: center;
                }
            }
            .row,.specs-header {
                padding: 5px 0;
                margin-bottom: 5px;
                font-size: 18px;
                font-weight: 600;
                @media (max-width:590px) {
                    flex-wrap: nowrap;
                }
            }
        }
        .thumbs {
            .thumb-link {
                cursor: pointer;
                border: 1px solid #1b4b72;
            }
        }

        .preview {
            img {
                width: 100%;
            }
        }

        .attr-row {
            margin: 10px 0;
            @media (max-width:590px) {
                flex-wrap: nowrap;
            }
        }

        .attr-color {
            width: 30px;
            height: 30px;
            border-radius: 30px;
            display: inline-block;
            margin-right: 10px;
        }

        .attr-tag {
            margin-right: 5px;
            padding: 3px 10px;
            display: inline-block;
            background: #373535;
            border: 1px solid #6c6c6c
        }
        .nav-tabs {
            display: flex;
            justify-content: center;
            a {
                color: #e7e7e7 !important;
            }
        }
        .tabs {
            width: 70%;
            @media (max-width: 590px) {
                width: 100%;
            }
        }
        .b-table {
            border-spacing: 0 20px;
        }
        .tab-content {
            background: #4c4b4b !important;
            padding: 10px;
        }
    }
</style>
