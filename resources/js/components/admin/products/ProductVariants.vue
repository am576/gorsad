<template>
    <div class="mt-4 mb-4">
        <div class="form-row col-10 align-items-end" v-for="(variant, index) in product_variants" :key="index">
            <div class="col-2">
                <label>Тип</label>
                <select style="width: 100%; height: 35px" name="type" id="type" v-model="product_variants[index].type" @change="updateProductVariant(index)">
                    <option value="st">Штамб</option>
                    <option value="mtst">Мультиштамб</option>
                    <option value="sol">Солитер</option>
                </select>
            </div>
            <div class="col-2">
                <label>Высота</label>
                <div class="d-flex align-items-center">
                    <input class="form-control" type="text" v-model="product_variants[index].height[0]" @keyup="updateProductVariant(index)">
                    <span class="pl-1 pr-2">-</span>
                    <input class="form-control" type="text" v-model="product_variants[index].height[1]" @keyup="updateProductVariant(index)">
                </div>
            </div>
            <div class="col-2">
                <label>Обхват</label>
                <div class="d-flex align-items-center">
                    <input class="form-control" type="text" v-model="product_variants[index].width[0]" @keyup="updateProductVariant(index)">
                    <span class="pl-1 pr-2">-</span>
                    <input class="form-control" type="text" v-model="product_variants[index].width[1]" @keyup="updateProductVariant(index)">
                </div>
            </div>
            <div class="col-2">
                <label>Цена</label>
                <input class="form-control" type="text" v-model="product_variants[index].price" @keyup="updateProductVariant(index)">
            </div>
            <div class="col-2">
                <label>Цена в баллах</label>
                <input class="form-control" type="text" v-model="product_variants[index].bonus_price" @keyup="updateProductVariant(index)">
            </div>
            <div class="col">
                <label>Баллы</label>
                <input class="form-control" type="text" v-model="product_variants[index].bonus_value" @keyup="updateProductVariant(index)">
            </div>
            <button type="button" class="btn btn-danger delete" tabindex="-1"
                    @click="removeProductVariant(index)"><i class="mdi mdi-minus"></i></button>
        </div>
        <button type="button" class="btn btn-success clonspan mt-4" tabindex="-1" @click="createProductVariant()"><i
            class="mdi mdi-plus"></i></button>
    </div>
</template>

<script>
    export default {
        props: {
            product: {}
        },
        data() {
            return {
                product_variants: []
            }
        },
        methods: {
            createProductVariant() {
                this.$set(this.product_variants, this.product_variants.length, {height: [], width: []});
            },
            removeProductVariant(index) {
                this.$emit('removeVariant', index);
                this.$forceUpdate();
            },
            updateProductVariant(index) {
               this.$emit('changeVariant', index, this.product_variants[index])
            },
            populateProductVariants() {
                this.product_variants = this.product.variants;
                this.product_variants.forEach(variant => {
                    variant.height = variant.height.split(',');
                    variant.width = variant.width.split(',');
                })
            }
        },
        created() {
            if(typeof this.product === 'object' && this.product !== null) {
                this.populateProductVariants();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .delete {
        height: 50%;
    }
    .clonspan {
        margin: 0 15px;
    }
</style>
