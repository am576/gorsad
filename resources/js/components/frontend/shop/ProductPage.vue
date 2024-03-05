<template>
    <div id="product-page" class="product-page">
        <div class="row justify-content-start m-0 top-block">
            <div class="image-wrapper col-lg-5 col-sm-12">
                <div class="display-image" :style="{'background-image':'url(/storage/images/' + product.images[0].large +')'}">
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="mb-4">
                    <h3 class="product-title">{{product.title}}</h3>
                </div>
                <div class="attributes-brief">
                    <div v-if="productHeight()">
                        <span class="brief-title">Высота</span>
                        <div class="brief-wr d-flex justify-content-between">
                            <img src="/storage/images/public/icons/icon_height.png" alt="">
                            <div class="brief-value">{{ productHeight() }}</div>
                        </div>
                        </div>
                    <div v-if="productPaving()">
                        <span class="brief-title">Мощение</span>
                        <div class="brief-wr d-flex justify-content-between">
                            <img src="/storage/images/public/icons/icon_paving.png" alt="">
                            <div class="brief-value">{{ productPaving() }}</div>
                        </div>
                    </div>
                    <div v-if="productWinterZone()">
                        <span class="brief-title">Зона зимостойкости</span>
                        <div class="brief-wr d-flex justify-content-between">
                            <img src="/storage/images/public/icons/icon_winter_zone.png" alt="">
                            <div class="brief-value" v-html="productWinterZone()"></div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="product-variants" v-if="hasVariants">
            <table>
                <thead>
                    <th>Обхват ствола</th>
                    <th>Размер кома/вес</th>
                    <th>Упаковка</th>
                    <th class="text-center">Количество</th>
                    <th>Срок доставки</th>
                    <th></th>
                </thead>
                <tbody>
                    <tr v-for="variant in product.variants.st">
                        <td width="120">{{ variantWidth(variant)[0] }} - {{ variantWidth(variant)[1] }}</td>
                        <td width="150">{{ variantWeight(variantWidth(variant)[1]) }}</td>
                        <td>Мешковина+сетка</td>
                        <td>
                            <v-text-field
                                solo
                                readonly="true"
                                prepend-inner-icon="mdi-minus"
                                append-icon="mdi-plus"
                                v-model="quantities[variant.id]"
                                @click:append="changeQuantity(variant.id, quantities[variant.id] + 1)"
                                @click:prepend-inner="changeQuantity(variant.id, quantities[variant.id] - 1)"
                            >
                            </v-text-field>
                            <!-- <input class="quantity-input" type="number" oninput="(value>0 ||validity.valid)||(value='1');" onchange="value = validity.valid && value > 0 ? value : 1" v-model="quantities[variant.id]" v-if="variant.price > 0"> -->
                        </td>
                        <td class="text-left">
                            Сделайте предварительный заказ сейчас!
                        </td>
                        <td>
                            <button class="btn btn-green buy-btn" @click="addToCart(variant.id)" v-if="variant.price > 0">
                                <span class="mdi mdi-cart mdi-24px"></span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end" style="gap: 30px;">
                <div style="width: 20%; font-size: 20px;">Для расчёта стоимости, перейдите в корзину</div>
                <button class="btn-green" type="button">Перейти в корзину</button>
            </div>
        </div>
        <div v-else class="mt-5 mb-5">
            <div class="d-flex justify-content-center" style="gap: 30px;">
                <div style="width: 40%; font-size: 20px;">Для уточнения цены, пожалуйста, оставьте заявку, или свяжитесь с нами по телефону</div>
                <button class="btn-green" type="button">Оставить заявку</button>
            </div>
        </div>
        <product-images :product="product" v-if="product.images.length"></product-images>
        <div class="product-description">
            <h3 class="product-title">{{product.title}}</h3>
            <p class="product-description-text">
                {{ product.description }}
            </p>
        </div>
        <table class="product-attributes table table-striped">
            <tbody>
                <tr v-for="attribute in product.attributes">
                    <td class="text-left">
                        {{ attribute.name }}
                    </td>
                    <td class="text-right">
                        <div v-if="isTagType(attribute)">
                            <span class="attr-tag" v-for="attr_value in attribute.values">{{attr_value.value}}</span>
                        </div>
                        <div v-if="attribute.type === 'range'">
                            <span v-if="attribute.values.length > 1">{{attribute.values[0].value}}м - {{attribute.values[1].value}}м</span>
                            <span v-else-if="attribute.values .length === 1">{{attribute.values[0].value}}м</span>
                        </div>
                        <div v-if="attribute.type === 'icon'" class="d-flex align-items-center justify-content-end">
                            <div class="d-flex align-items-center" v-for="(attr_value, index) in attribute.values">
                                <span>{{attr_value.value}}</span>
                                <img height="40" :src="'/storage/images/' + attr_value.icon.image.icon" alt="" style="margin-left: 10px;">
                            </div>
                        </div>
                        <div v-if="attribute.type === 'text' && !isTagType(attribute)" v-for="attr_value in attribute.values">
                            {{attr_value.value}} 
                            <div class="d-inline-block" v-if="attribute.name==='Зимостойкость'">
                                (<span v-html="productWinterZone()"></span>)
                            </div>
                        </div>
                        <div v-if="attribute.type === 'color'">
                            <span class="attr-color" v-for="color in attribute.values"
                                v-bind:style="{background: color.value}">
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Синонимы</td>
                    <td class="text-right">{{ product.title_lat }}</td>
                </tr>
            </tbody>
        </table>
        <!-- RESERVED FOR PROJECT USAGE IMAGES -->
<!--        <shopping-cart></shopping-cart>-->
    </div>
</template>

<script>
    import moment from "moment";
    import winterZones from "@js/data/winterZones.js"

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
            setActiveTab(new_tab) {
                this.activeTab = new_tab;
            },
            isTabActive(type) {
                return type === this.activeTab;
            },
            changeQuantity(variant_id, new_quantity) {
                let quantity = 0;
                if (Number.isInteger(new_quantity) && new_quantity >= 0) {
                    quantity = new_quantity
                }
                this.$set(this.quantities, variant_id, quantity)
                this.$forceUpdate();
                // this.quantities[variant_id] = new_quantity;
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
            },
            // ========================= 
            productHeight() {
                const attribute = this.product.attributes.find(attribute => attribute.name === 'Высота');
                if(attribute) {
                    let product_height = attribute.values.length > 1 ? `${attribute.values[0].value} - ${attribute.values[1].value}м` : `${attribute.values[0].value}`
                    return product_height
                }
                return "";
            },
            productPaving() {
                const attribute = this.product.attributes.find(attribute => attribute.name === 'Мощение');
                if(attribute) {
                    return `${attribute.values[0].value}`
                }
                return "";
            },
            productWinterZone() {
                const attribute = this.product.attributes.find(attribute => attribute.name === 'Зимостойкость');
                if(attribute) {
                    const zone_index = attribute.values[0].value
                    const zone = winterZones.find(zone => zone.index === zone_index);
                    if (zone) {
                        const [min, max] = zone.range;
                        return `${min} &#8212 ${max}°C`;
                        } 
                        else {
                            return 'Temperature range not available';
                        }
                }
            },
            variantWidth(variant) {
                const width_string = variant.width;
                return width_string.split(',')
            },
            variantWeight(width) {
                return width * 10
            }
        },
        computed: {
            hasVariants() {
                return Object.keys(this.variants_table_data.items).length > 0
            }
        },
        created() {
            this.setVariantsTableData()
            this.replaceMissingImages();
            this.setCurrentImage(this.product.images[0]);
            if(this.hasVariants) {
                this.setActiveTab(Object.keys(this.variants_table_data.items)[0])
            }
        },
    }
</script>

<style lang="scss">
    @import '@/_variables.scss';
    .product-page {
        padding-top: 35px;
        .top-block {
            display: flex;
            gap: 30px
        }
        color: $text-color;
        .product-title {
            font-family: $font-family-sans-serif;
            font-weight: normal;
            font-size: 30px;
            margin-bottom: 40px !important;
        }
        .product-description-text {
            font-size: 18px;
            line-height: 30px;
            font-family: $font-gilroy;
            font-weight: normal;
        }
        .attributes-brief {
            font-family: $font-glory;
            display: flex;
            justify-content: flex-start;
            gap: 60px;
            color: #000000;
            div {
                flex: -0.5;
                gap:20px;
            }
            .brief-wr {
                padding-top: 5px;
            }
            .brief-title {
                font: $font-glory;
                font-size: 12px;
                color: #4f4f4f;
            }
            .brief-value {
                font-size: 18px;
            }
        }
        button.buy-btn {
            border: none;
            padding: 0 25px !important;
            background: #4c4b4b;
            border-radius: 0 !important;
        }
        .product-variants {
            margin-top: 100px;
            margin-bottom: 100px;
            table {
                margin: auto;
                margin-bottom: 45px;
                width: 90%;
                th {
                    font: $font-glory;
                    font-size: 12px;
                    color: $text-color;
                    font-weight: normal;
                }
                tr {
                    border-bottom: 1px solid #9f9f9f
                }
                td {
                    padding-top: 20px;
                    padding-bottom: 20px;
                }    
                .v-input {
                    width: 40%;
                    margin: auto;
                }
                .v-text-field__slot {
                    input {
                        text-align: center;
                    }
                }
                .v-text-field__details {
                    display: none;
                }
            }
        }
        .image-wrapper {
            padding: 10px;
        }
        .display-image {
            min-height: 440px;
            width: 440px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
        }
        .product-description {
            width: 85%;
            margin: 75px auto 50px;
        }
        table.product-attributes {
            margin: auto;
            margin-bottom: 100px;
            width: 70%;
            tbody tr:nth-of-type(2n+1) {
                background-color: #ffffff;
            }
            td {
                vertical-align: middle;
            }
        }
        .all-specs {
            width: 80%;
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
            background: #eaeaea;
            border: 1px solid #726155
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
