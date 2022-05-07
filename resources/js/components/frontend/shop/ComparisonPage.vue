<template>
    <div id="comparison" class="row">
        <div class="comparison-table m-auto w-100">
            <div class="row flex-nowrap">
                <div class="product"></div>
                <div class="product mr-4 d-flex flex-column justify-content-end position-relative" v-for="(product, i) in comparison.products" :key="i">
                    <a class="link-passive" :href="'/shop/products/' + product.id">
                        <h5 class="d-flex align-items-center">
                            <span class="mr-3">{{product.title}}</span>
                            <span class="align-self-start">
                                <span class="remove-from-compare mdi mdi-24px mdi-close" @click.prevent="removeFromCompare(i)"></span>
                            </span>
                        </h5>
                        <img class="product-thmb" :src="'/storage/images/'+product.image.small" alt="">
                    </a>
                </div>
            </div>
            <div v-for="attribute in comparison.attributes">
                <div class="pl-2">
                    <h4>{{attribute.name}}</h4>
                </div>
                <div class="d-flex pl-2 compare-row flex-nowrap mb-4" v-for="(value, index) in formatAttributeValues(attribute.values)" v-if="attribute.type === 'text'" :key="index">
                    <div class="attr-check pl-1">{{value}}</div>
                    <div class="attr-check text-center" v-for="product in comparison.products">
                        <i class="mdi mdi-48px mdi-check-circle-outline" v-if="hasAttributeValue(product, attribute.id, attribute.ids.split(',')[index])"></i>
                        <i class="mdi mdi-48px mdi-close-circle-outline" v-if="!hasAttributeValue(product, attribute.id, attribute.ids.split(',')[index])"></i>
                    </div>
                </div>
                <div class="d-flex pl-2 compare-row flex-nowrap mb-4" v-if="attribute.type !== 'text'">
                    <div class="attr-check"></div>
                    <div class="attr-check" v-for="product in comparison.products" >
                        <div class="text-center" v-if="hasAttribute(product, attribute.id)">
                            <span v-if="attribute.type === 'range'">{{formatRangeAttribute(product, attribute)}}</span>
                            <span v-if="attribute.type === 'color'" class="attr-color" v-for="color in product.attributes[attribute.id].values"
                                  v-bind:style="{background: color.value}">
                            </span>
                            <div class="d-flex align-items-center" v-if="attribute.type === 'icon'">
                                <span>{{product.attributes[attribute.id].values[0].value}}</span>
                                <img :src="'/storage/images/' + product.attributes[attribute.id].values[0].icon.image.icon" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            comparison: {
                type: Object,
                default: {}
            },
        },
        methods: {
            hasAttribute(product, attribute_id) {

                return product.attributes.hasOwnProperty(attribute_id);
            },
            hasAttributeValue(product, attribute_id, value_id) {
                let has = false;
                if(product.attributes.hasOwnProperty(attribute_id)) {
                    product.attributes[attribute_id].values.forEach(value => {
                        if(Number(value.id) === Number(value_id)){
                            has = true;
                        }
                    })
                }
                return has;
            },
            formatRangeAttribute(product, attribute) {
                const range_from =  product.attributes[attribute.id].values[0].value;
                const range_to =  product.attributes[attribute.id].values[1].value;

                return range_from + ' - ' + range_to;
            },
            formatAttributeValues(values) {
                return [...new Set(values.split(','))]
            },
            removeFromCompare(i) {
                axios.post('/shop/compare/remove', {
                    product_id: this.comparison.products[i].id
                });
                this.$delete(this.comparison.products, i);
                if(this.comparison.products. length <= 1) {
                    this.$emit('closeComparison');
                }
            },
        }
    }
</script>
<style lang="scss" scoped>
    #comparison {
        width: 100%;
        margin-top: 25px;
        @media (max-width:1300px) {
            overflow-x: auto;
        }

        img.product-thmb {
            width: 200px;
            height: 200px;
        }
        .comparison-table {
            color: white !important;

            .product, .attr-check {
                flex: 0 0 200px;
                width: 200px;
                margin-right: 1.5rem;
            }
            .attr-check {
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .compare-row {
                margin-top: 10px;
                .col {
                    display: flex;
                    align-items: center;
                }
            }
            .attr-color {
                width: 30px;
                height: 30px;
                border-radius: 30px;
                display: inline-block;
                margin-right: 10px;
            }
        }
        .remove-from-compare {
            display: block;
            color: #fff;
            width: 30px;
            text-align: center;
            border-radius: 50px;
            background-color: rgba(0, 0, 0, 0.9);
            cursor: pointer;
            &:hover {
                background-color: #1f3339;
            }
        }
    }
</style>
