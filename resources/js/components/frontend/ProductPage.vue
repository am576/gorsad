<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-6">
                <product-images :product="product"></product-images>
            </div>
            <div class="col-6">
                <div class="p-3" style="border: 1px solid #2a9055; height: 100% ">
                    <h5 class="text-success">{{product.additional_info.family}}</h5>
                    <h3>{{product.title}}</h3>
                    <h5 class="text-muted">{{product.additional_info.common_name}}</h5>
                    <div>----</div>
                    <div>
                        <p v-html="product.description"></p>
                        <h5>Характеристики</h5>
                        <div class="attr-row row">
                            <div class="col-md-4">Высота</div>
                            <div class="col-md-8">{{height[0]}} - {{height[1]}} м.</div>
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
                    <button class="btn btn-primary" @click="addToCart">Купить</button>
                </div>
            </div>
        </div>
        <nav class="mt-3">
            <b-tabs  horizontal nav-wrapper-class="w-75">
                <b-tab title="Штамб(St)" active>
                    <b-table :fields="variants_table_data('st').fields" :items="variants_table_data('st').items">
                        <template #cell(quantity)="data">
                            <input type="text" :value="data.value">
                        </template>
                        <template #cell(buy)="data">
                            <button>Buy</button>
                        </template>
                    </b-table>
                </b-tab>
                <b-tab title="Мультиштамб(MtSt)">
                    <b-table :fields="variants_table_data('mtst').fields" :items="variants_table_data('mtst').items">
                        <template #cell(quantity)="data">
                            <input type="text" :value="data.value">
                        </template>
                        <template #cell(buy)="data">
                            <button>Buy</button>
                        </template>
                    </b-table>
                </b-tab>
                <b-tab title="Солитер(Sol)">
                    <b-table :fields="variants_table_data('sol').fields" :items="variants_table_data('sol').items">
                        <template #cell(quantity)="data">
                            <input type="text" :value="data.value">
                        </template>
                        <template #cell(buy)="data">
                            <button>Buy</button>
                        </template>
                    </b-table>
                </b-tab>
            </b-tabs>
        </nav>
        <div class="user-reviews mt-5">
            <h2>Отзывы</h2>
            <b-card v-for="(review,index) in product.reviews" :key="index" :title="review.user.name" :sub-title="moment(product.created_at).format('DD.MM.YYYY hh:mm')" class="mt-4">
                <b-card-text>Достоинства: {{review.pluses}}</b-card-text>
                <b-card-text>Недостатки: {{review.minuses}}</b-card-text>
                <b-card-text>Комментарий: {{review.comment}}</b-card-text>
            </b-card>
        </div>
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
                variants_fields: ['Высота', 'Обхват ствола',]
            }
        },
        methods: {
            setCurrentImage(image) {
                this.current_image = image;
            },
            addToCart() {
                axios.get('/cart/add', {
                    params: {
                        'product_id': this.product.id
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
            variants_table_data(type) {
                const labels = [
                    {key: 'height', 'label': 'Высота'},
                    {key: 'width', 'label': 'Обхват ствола'},
                    {key: 'price', 'label': 'Цена'},
                    {key: 'quantity', 'label': 'Количество'},
                    {key: 'buy', 'label': ''},
                ];
                let rows = [];

                this.product.variants[type].forEach(variant => {
                    rows.push(
                        {
                            height: variant.height,
                            width: variant.width,
                            price: variant.price,
                            quantity: 1,
                            buy: ''
                        }
                    )
                })

                return {
                    fields: labels,
                    items: rows
                }
            },

        },
        computed: {


        },
        created() {
            this.setCurrentImage(this.product.images[0]);
            this.$set(this.product, 'additional_info', JSON.parse(this.product.additional_info));
        }
    }
</script>

<style lang="scss" scoped>
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
        display: inline-block;
        background: #a39d9d;
        height: 20px;
    }
</style>
