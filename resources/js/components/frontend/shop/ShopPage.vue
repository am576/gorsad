<template>
    
    <div>
        <div class="shop-page">
            <div id="catalog-filter" class="col-3">
                <div class="category" v-for="attribute_group in attributes">
                    <h4 class="category-name">{{ attribute_group.group_name }}</h4>
                    <div v-for="attribute in attribute_group.attributes">
                        <button class="attribute-name btn btn-light btn-block" v-b-toggle="'attribute-' + attribute.id">
                            <span class="d-flex align-items-center" style="gap: 10px;">
                                <i class="mdi mdi-chevron-right mdi-24px"></i>
                                {{ attribute.name }}
                            </span>
                        </button>
                        <b-collapse class="attribute-values" :id="'attribute-' + attribute.id">
                            <div v-if="attribute.type === 'text'" class="mt-1 mb-1" v-for="value in attribute.values">
                                <div @click="addFilterOption(attribute.id, value.id)"> 
                                    <span class="attribute-value" :class="{'text-success':isSelected(attribute.id, value.id)}">
                                        {{ value.value }}
                                    </span>
                                </div>
                            </div>
                            <div v-if="attribute.type === 'range'">
                                <vue-slider
                                    v-model="range"
                                    :tooltip-placement="'bottom'"
                                    :enable-cross="false"
                                    :data="attribute.values"
                                    :data-value="'id'"
                                    :data-label="'value'"
                                    :marks="false"
                                    :hide-label="true"
                                    @change="applyRangeFilter(attribute.id)"
                                ></vue-slider>
                            </div>
                            <div class="color-attribute-wr" v-if="attribute.type === 'color'">
                                <span 
                                    class="color-icon-wr" 
                                    v-for="value in attribute.values" 
                                    @click="addFilterOption(attribute.id, value.id)"
                                    :tooltip="value.ext_value"
                                    :class="{'selected':isSelected(attribute.id, value.id)}"
                                >
                                        <i class="mdi mdi-leaf mdi-24px" v-bind:style="{color: value.value}" ></i>
                                </span>
                            </div>
                            <div class="icon-attribute-wr" v-if="attribute.type === 'icon'">
                                <div class="icon-img-wr" :class="{'selected':isSelected(attribute.id, value.id)}" v-for="value in attribute.values" @click="addFilterOption(attribute.id, value.id)">
                                    <img 
                                        :src="'/storage/images/' + value.icon" alt="" 
                                        
                                        
                                    >
                                    {{ value.value }}
                                </div>
                            </div>
                        </b-collapse>
                    </div>
                </div>
            </div>
            <div class="product-list col-9">
                <div class="product-card" v-for="product in products" :key="product.id" >
                    <div class="product-thumb" v-bind:style="{'background-image':productThumbnail(product)}">
                    </div>
                    <div class="product-name">
                        {{ product.title }}
                    </div>
                    <div>
                        <a :href="'/catalog/trees/'+product.id">
                            <button class="btn-green w-100" type="button">Описание</button>
                        </a>
                    </div>
                </div>
                <div v-if="noProductsFound" class="no-results-msg">По вашему запросу ничего не найдено.</div>
            </div>
            <button class="load-more-btn btn-green" @click="loadMore" v-if="products_all.current_page < products_all.last_page">Загрузить ещё</button>
        </div>
        
        
  </div>
</template>

<script>
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/default.css'
    export default {
        components: {
            VueSlider,
        },
        props: {
            products_all: {
                type: Object
            },
            attributes: {
                type: Array,
            },
            user: {
                type: Object
            },
            filter_options: {
                type: Object,
                default: {}
            },
            filtered_name: {
                type: String,
                default: ''
            },
            cart: {},
            filter_product_name : ""
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                products: [],
                showFilters : true,
                isMobileView: false,
                showComparison: false,
                productsToCompare: [],
                compareProducts: [],
                hasFilterOptions: false,
                filter: {},
                selectedValues: [],
                range: []
            }
        },
        methods: {
            loadProducts(page = 1) {
                if(!Object.keys(this.filter).length) {
                    axios.get(`/api/products?page=${page}`)
                    .then(response => {
                        if (this.products) {
                            this.products = this.products.concat(response.data.data);
                            this.products_all.current_page = page
                        } else {
                            this.products = response.data;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading products:', error);
                    });
                }
                else {
                    this.loadFilteredProducts(page)
                }
            },
            loadMore() {
                this.loadProducts(this.products_all.current_page + 1);
            },
            productThumbnail(product) {
                if(product.image) {
                    return `url(/storage/images/${product.image.medium})`
                }
            },
            setRangeDefaults() {
                let attributes = this.attributes.flatMap(obj => obj.attributes)
                attributes.forEach(attribute => {
                    if (attribute.type === 'range') {
                        this.range.push(attribute.values[0].id)
                        this.range.push(attribute.values.slice(-1)[0].id)
                    }
                });
                this.$forceUpdate();
            },
            addFilterOption(attr_id, value_id) {
                if (this.filter.hasOwnProperty(attr_id)) {
                    if (this.filter[attr_id].includes(value_id)) {
                        if(this.filter[attr_id].length === 1) {
                            this.$delete(this.filter, attr_id)
                        }
                        else {
                            this.filter[attr_id].splice(this.filter[attr_id].indexOf(value_id), 1)
                        }
                        
                    }
                    else {
                        this.filter[attr_id].push(value_id)
                    }    
                }
                else {
                    this.filter[attr_id] = [value_id]
                }
                this.toggleSelection(attr_id, value_id)
                this.loadFilteredProducts()
                
            },
            loadFilteredProducts(page = 1) {
                axios.post('/catalog/filter', {
                    product_name: this.filter_product_name,
                    filter: this.filter,
                    page: page
                })
                .then(response => {
                    if (page > 1) {
                        this.products = this.products.concat(response.data.data);
                        this.products_all.current_page = page
                    } else {
                        this.products = response.data.data;
                    }
                })
            },
            applyRangeFilter(attribute_id) {
                let selected_range = []
                for (let i = this.range[0]; i <= this.range[1]; i++) {
                    selected_range.push(i);
                }
                this.filter[attribute_id] = selected_range
                this.loadFilteredProducts()
            },
            filterProducts(products, filter_options) {
                let isFilter = false;
                this.products = 'data' in products ? products.data : products;
                    this.hasFilterOptions = true;
                this.$eventBus.$emit('updateProductsList', this.products, true);
            },
            toggleFilters() {
                this.showFilters = !this.showFilters;
            },
            handleView() {
                this.isMobileView = window.innerWidth <= 600;
            },
            showSigninForm() {
                this.$refs.signinForm.showModal();
            },
            logout() {
                this.$refs.logout.submit()
            },
            showCart() {
                this.$eventBus.$emit('showCart')
            },
            isSelected(attributeId, valueId) {
                return this.selectedValues.some((selection) => {
                    return selection.attributeId === attributeId && selection.valueId === valueId;
                });
            },
            toggleSelection(attributeId, valueId) {
                const index = this.selectedValues.findIndex((selection) => {
                    return selection.attributeId === attributeId && selection.valueId === valueId;
                });

                if (index === -1) {
                    this.selectedValues.push({ attributeId, valueId });
                } else {
                    this.selectedValues.splice(index, 1);
                }
            },
            valueSelected(attr_id, value_id) {
                console.log(attr_id);
                if (this.filter.hasOwnProperty(attr_id)) {
                    console.log(this.filter[attr_id].includes(value_id));
                    return this.filter[attr_id].includes(value_id)
                }
            },
            setValues(attribute){
                if(attribute.type === 'range') {
                    
                }
            },
            /*getComparison() {
                axios.get('/shop/comparison')
                    .then(response => {
                        if(response.data) {
                            this.productsToCompare = [];
                            this.compareProducts = response.data;
                            this.compareProducts.products.forEach(product => {
                                this.productsToCompare.push(product.id)
                            })
                        }
                    })
            },
            toggleComparisonPage() {
                this.toggleFilters();
                this.getComparison();
                if(this.showComparison === false) {
                    this.showComparison = true;
                    axios.get('/shop/comparison')
                        .then(response => {
                            this.compareProducts = response.data;
                        })
                }
                else {
                    this.showComparison = false;
                }
            },
            closeComparison() {
                this.getComparison();
                this.showComparison = false;
            },
            toggleProductCompare(id) {
                if(this.productsToCompare.includes(id)) {
                    this.$delete(this.productsToCompare, this.productsToCompare.indexOf(id));
                }
                else {
                    if(this.productsToCompare.length < 5) {
                        this.productsToCompare.push(id);
                    }
                    else {
                        return;
                    }
                }
                const formData = new FormData();
                this.productsToCompare.forEach(id => {
                    formData.append('products[]', id);
                })
                axios.post('/shop/compare/add', formData);
            },*/

        },
        computed: {
            isGuest() {
                return this.user == null;
            },
            filterBtnCaption() {
                return this.showFilters ? 'Скрыть фильтры' : 'Показать фильтры';
            },
            noProductsFound() {
                return this.products.length === 0;
            }
        },
        created() {
            this.products = 'data' in this.products_all ? this.products_all.data : this.products_all;
            this.setRangeDefaults();
            // this.getComparison();
            // this.$eventBus.$on('toggleProductCompare', this.toggleProductCompare);

        }
    }
</script>
<style lang="scss" scoped>
    @import '@/_variables.scss';
    .shop-page {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        flex: 1;
        margin-left: -15px;
        margin-right: -15px;
        margin-top: 30px;
        padding-bottom: 50px;

        #catalog-filter {
            .category {
                margin-top: 20px;
                .category-name {
                    font-family: $font-family-sans-serif;
                    font-size: 18px;
                    color: $text-color;
                    padding-left: 10px;
                }
                .attribute-name {
                    font-family: $font-gilroy;
                    font-size: 16px;
                    text-align: left;
                    color: $text-color;
                    padding: 0;
                }
                .attribute-values {
                    padding-left: 20px;
                    .attribute-value {
                        font-family: $font-gilroy;
                        font-size: 14px;
                        color: $text-color;
                        cursor: pointer;
                        margin-top: 15px;
                        margin-bottom: 15px;
                    }
                    .color-attribute-wr {
                        //background: #2c2c2c;
                        display: flex;
                        flex-wrap: wrap;
                        margin: 10px 0;
                        padding: 0 10px;
                        .color-icon-wr {
                            width: 30px;
                            height: 30px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            border: 1px solid rgba(255, 0, 0, 0);
                            border-radius: 100px;
                            &.selected {
                                border: 1px solid rgba(255, 0, 0, 1);
                            }
                        }
                        i {
                            text-shadow: 0px 0px 2px rgba(160,160,160,0.8);
                            cursor: pointer;
                        }
                    }
                    .icon-attribute-wr {
                        color: $text-color;
                        padding: 10px;
                        display: flex;
                        flex-wrap: wrap;
                        .icon-img-wr {
                            cursor: pointer;
                            margin-top: 5px;
                            margin-bottom: 5px;
                            width: 100%;
                            display: flex;
                            align-items: center;
                            &.selected {
                                background: #ececec;
                            }
                        }
                        img {
                            width: 30px;
                            border: 1px solid #ffffff00;
                            border-radius: 100px;
                            
                        }
                    }
                }
                
            }
        }
        .no-results-msg {
            grid-column: 1 / span 2;
            text-align: center;
        }
        .load-more-btn {
            margin-top: 50px;
        }
    }
    
</style>
