<template>
    <div id="comparison" class="row">

        <div class="container comparison-table">
            <div class="row">
                <div class="col"></div>
                <div class="col d-flex flex-column position-relative" v-for="(product, i) in comparison.products" :key="i">
                    <h5>{{product.title}}</h5>
                    <img class="product-thmb" :src="'/storage/images/'+product.image" alt="">
                    <span class="remove-from-compare mdi mdi-24px mdi-close" @click="removeFromCompare(i)"></span>
                </div>
            </div>
            <div v-for="attribute in comparison.attributes">
                <div v-if="attribute.type === 'text'">
                    <h4>{{attribute.name}}</h4>
                </div>
                <div v-for="(value, index) in attribute.values.split(',')" v-if="attribute.type === 'text'" :key="index">
                    <div class="row compare-row">
                        <div class="col">{{value}}</div>
                        <div class="col" v-for="product in comparison.products">
                            <i class="mdi mdi-48px mdi-check-circle-outline" v-if="hasAttributeValue(product, attribute, index)"></i>
                            <i class="mdi mdi-48px mdi-close-circle-outline" v-if="!hasAttributeValue(product, attribute, index)"></i>
                        </div>
                    </div>
                </div>
                <div class="row compare-row">
                    <div class="col" v-if="attribute.type === 'range'">
                        <h4>{{attribute.name}}</h4>
                    </div>
                    <div class="col" v-for="product in comparison.products" v-if="hasAttribute(product, attribute.id) && attribute.type === 'range'">
                        <div>{{formatRangeAttribute(product, attribute)}}</div>
                    </div>
                </div>
                <div class="row compare-row">
                    <div class="col" v-if="attribute.type === 'color'">
                        <h4>{{attribute.name}}</h4>
                    </div>
                    <div class="col" v-for="product in comparison.products" >
                        <div v-if="hasAttribute(product, attribute.id) && attribute.type === 'color'">
                            <span class="attr-color" v-for="color in product.attributes[attribute.id].values"
                                  v-bind:style="{background: color}">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row compare-row">
                    <div class="col" v-if="attribute.type === 'icon'">
                        <h4>{{attribute.name}}</h4>
                    </div>
                    <div class="col" v-for="product in comparison.products" >
                        <div class="d-flex align-items-center" v-if="hasAttribute(product, attribute.id) && attribute.type === 'icon'">
                            <span>{{product.attributes[attribute.id].values[0]}}</span>
                            <img :src="'/storage/images/' + product.attributes[attribute.id].icon" alt="">
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
            hasAttributeValue(product, attribute, index) {
                const ids = attribute.ids.split(',');
                const value = ids[index];

                if(product.attributes.hasOwnProperty(attribute.id)) {
                    return product.attributes[attribute.id].values.includes(value);
                }
            },
            formatRangeAttribute(product, attribute) {
                const range_from =  product.attributes[attribute.id].values[0];
                const range_to =  product.attributes[attribute.id].values[1];

                return range_from + ' - ' + range_to;
            },
            removeFromCompare(i) {
                this.$delete(this.comparison.products, i);
                if(this.comparison.products. length <= 1) {
                    this.$emit('closeComparison');
                }
            }
        },
        created() {

        }
    }
</script>
<style lang="scss" scoped>
    #comparison {
        width: 100%;
        margin: 0 !important;

        img.product-thmb {
            width: 200px;
            height: 200px;
        }
        .comparison-table {
            color: white !important;

            .compare-row {
                margin-top: 10px;
                .col {
                    display: flex;
                    align-items: center;
                }
            }
            .compare-attr-title {

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
            position: absolute;
            bottom: 5px;
            left: 220px;
            color: #fff;
            width: 35px;
            text-align: center;
            border-radius: 50px;
            background-color: rgba(0, 0, 0, 0.9);
            cursor: pointer;
        }
    }
</style>
