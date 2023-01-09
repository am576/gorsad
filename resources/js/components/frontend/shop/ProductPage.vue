<template>
    <div id="product-page" class="product-page">
        <div class="row justify-content-start m-0">
            <div class="image-wrapper col-lg-6 col-sm-12">
                <div class="display-image" :style="{'background-image':'url(/storage/images/' + product.images[0].large +')'}">
                    <div class="product-name-rus">{{product.title}}</div>
                    <div class="product-name-lat">{{product.title_lat}}</div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12">
                <div class="p-3">
                    <h3>{{product.title}}</h3>
                    <h5 class="text-muted">{{product.title_lat}}</h5>
                    <div>----</div>
                    <div>
                        <p v-html="product.description"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="divider"></div>
        <!--<nav class="nav-tabs product-variants" v-if="hasVariants">
            <div class="tabs" horizintal="">
                <div class="tabs-wrapper d-flex justify-content-start">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" v-for="(tab_variant, type) in variants_table_data.items">
                            <a class="nav-link" href="#" @click.prevent="setActiveTab(type)" :class="[ isTabActive(type) ? ['active','tab_active'] : ''  ]">{{tabVariants[type].label}}</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane" v-for="(variant_type, type) in variants_table_data.items" :class="[ isTabActive(type) ? ['active','tab_active'] : ''  ]" >
                        <table class="table b-table table-borderless">
                            <thead role="rowgroup">
                            <tr>
                                <th v-for="field in variants_table_data.fields">
                                    <div>{{field.label}}</div>
                                </th>
                            </tr>
                            </thead>
                            <tbody role="rowgroup">
                            <tr class="table-row" role="row" v-for="variant in variant_type">
                                <td>{{variant.height}}</td>
                                <td>{{variant.width}}</td>
                                <td>
                                    <span v-if="variant.price > 0">{{variant.price}}</span>
                                </td>
                                <td>
                                    <input class="quantity-input" type="number" oninput="(value>0 ||validity.valid)||(value='1');" onchange="value = validity.valid && value > 0 ? value : 1" v-model="quantities[variant.id]" v-if="variant.price > 0">
                                </td>
                                <td>
                                    <button class="buy-btn" @click="addToCart(variant.id)" v-if="variant.price > 0">
                                        <span class="mdi mdi-cart-outline mdi-24px"></span>
                                    </button>
                                    <button style="padding: 10px !important; font-size: 16px;" class="buy-btn" @click="priceRequest(variant.id)" v-else>
                                        Запрос цены
                                    </button>
                                </td>
                                <td>
                                    <img height="50" v-if="variant.bonus_value > 0" src="/storage/images/public/bonus_icon.png" alt="" :title="'Покупка этого товара принесёт ' + variant.bonus_value + ' баллов'">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </nav>-->
        <div class="d-flex justify-content-center pb-5 mb-4 mt-4">
            <div class="all-specs">
                <div class="specs-header">
                    <h4 class="font-weight-bold">ХАРАКТЕРИСТИКИ</h4>
                </div>
                <div class="row" v-for="attribute in product.attributes">
                    <div class="col-lg-3 col-sm-4 d-flex align-items-center">
                        {{attribute.name}}
                    </div>
                    <div class="col-lg-9 col-sm-8">
                        <div v-if="isTagType(attribute)">
                            <span class="attr-tag" v-for="attr_value in attribute.values">{{attr_value.value}}</span>
                        </div>
                        <div v-if="attribute.type === 'range'">
                            {{attribute.values[0].value}} - {{attribute.values[1].value}}
                        </div>
                        <div v-if="attribute.type === 'text' && !isTagType(attribute)" v-for="attr_value in attribute.values">
                            {{attr_value.value}}
                        </div>
                        <div v-if="attribute.type === 'color'">
                        <span class="attr-color" v-for="color in attribute.values"
                              v-bind:style="{background: color.value}">
                        </span>
                        </div>
                        <div v-if="attribute.type === 'icon'" class="d-flex align-items-center">
                            <div class="d-flex align-items-center" v-for="(attr_value, index) in attribute.values">
                                <span>{{attr_value.value}}</span>
                                <img height="40" :src="'/storage/images/' + attr_value.icon.image.icon" alt="">
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
<!--        <shopping-cart></shopping-cart>-->
    </div>
</template>

<script>
    import moment from "moment";
    export default {
        props: {
            product: {},
        },
        data() {
            return {
                moment: moment,
                current_image: '',
                product_attributes: {},
                quantities: {},
                activeTab: {},
                tabVariants: {
                    'st':{label: 'Штамб(St)'},
                    'mtst':{label: 'Мультиштамб(MtSt)'},
                    'sol':{label: 'Солитер(Sol)'},
                    'h':{label: '(H)'},
                    'stbu':{label: 'STBU)'},
                },
                variants_table_data: {
                    fields: [],
                    items: {}
                },
                isGuest: false
            }
        },
        methods: {
            setActiveTab(new_tab) {
                this.activeTab = new_tab;
            },
            isTabActive(type) {
                return type === this.activeTab;
            },
            changeQuantity(variant, new_quantity) {
                this.quantities[variant] = new_quantity;
            },
            setCurrentImage(image) {
                this.current_image = image;
            },
            addToCart(variant_id) {
                let quantity = (variant_id in this.quantities && this.quantities[variant_id] > 0) ? this.quantities[variant_id] : 1;
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
                if(value) {
                    let ar = value.split(',');
                    return `${ar[0]} -  ${ar[1]} ${unit}.`
                }
                return 0;
            },
            setVariantsTableData() {
                this.variants_table_data.fields = [
                    {key: 'height', label: 'Высота'},
                    {key: 'width', label: 'Обхват ствола'},
                    {key: 'price', label: 'Цена'},
                    {key: 'quantity', label: 'Количество'},
                    {key: 'buy', label: ''},
                    {key: 'bonus', label: ''},
                ];
                Object.keys(this.product.variants).forEach((type) => {
                    this.product.variants[type].forEach(variant => {
                        if(!this.variants_table_data.items.hasOwnProperty(type)) {
                            this.$set(this.variants_table_data.items, type, []);
                        }
                        this.variants_table_data.items[type].push({
                            id: variant.id,
                            height: this.rangeFormatted(variant.height, 'см') || '',
                            width: this.rangeFormatted(variant.width, 'см') || '',
                            price: variant.price,
                            quantity: 1,
                            buy: variant,
                            bonus: variant
                        });
                        this.quantities[variant.id] = 0;
                    });
                })
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
                       large: 'products/noimage/noimage_large.jpg'
                   })
                }
            }
        },
        computed: {
            hasVariants() {
                return Object.keys(this.variants_table_data.items).length > 0
            }
        },
        created() {
            this.setVariantsTableData();
            this.replaceMissingImages();
            this.setCurrentImage(this.product.images[0]);
            if(this.hasVariants) {
                this.setActiveTab(Object.keys(this.variants_table_data.items)[0])
            }
        },
    }
</script>

<style lang="scss">
    .product-page {
        background: #434242;
        * {
            color: #e7e7e7;
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
            @media (max-width: 600px) {
                padding: 0;
            }
        }
        .display-image {
            min-height: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;

            @media (max-width: 600px) {
                width: 100vw;
                height: 50vh;
                min-height: 0;
                min-width: 0;
            }

            .product-name-rus {
                text-align: center;
                font-weight: bold;
                color: #ffffff !important;
                @media (min-width: 0px) {
                    font-size: 1.7rem;
                }
                @media (min-width: 460px) {
                    font-size: 2rem;
                }
                @media (min-width: 900px) {
                    font-size: 2.5rem;
                }
            }
            .product-name-lat {
                color: #ffffff !important;
                text-align: center;
                @media (min-width: 0px) {
                    font-size: 1.2rem;
                }
                @media (min-width: 460px) {
                    font-size: 1.5rem;
                }
                @media (min-width: 900px) {
                    font-size: 2rem;
                }
            }
        }
        .tabs-wrapper {
            width: 75%;
            @media (max-width: 600px) {
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
            @media (max-width: 600px) {
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
                @media (max-width:600px) {
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
            @media (max-width:600px) {
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
            @media (max-width: 600px) {
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
