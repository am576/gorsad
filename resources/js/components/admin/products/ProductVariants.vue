<template>
    <div class="mt-4 mb-4">
        <div class="form-row col-8 align-items-end" v-for="(variant, index) in product_variants" :key="index">
            <div class="col-3">
                <label>Тип</label>
                <select style="width: 100%; height: 35px" name="type" id="type" v-model="product_variants[index].type" @change="updateProductVariant(index)">
                    <option value="st">Штамб</option>
                    <option value="mtst">Мультиштамб</option>
                    <option value="sol">Солитер</option>
                </select>
            </div>
            <div class="col-3">
                <label>Высота</label>
                <div class="d-flex align-items-center">
                    <input class="form-control" type="text" v-model="product_variants[index].height[0]" @keyup="updateProductVariant(index)">
                    <span class="pl-1 pr-2">-</span>
                    <input class="form-control" type="text" v-model="product_variants[index].height[1]" @keyup="updateProductVariant(index)">
                </div>
            </div>
            <div class="col-3">
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
            <button type="button" class="btn btn-danger delete" tabindex="-1"
                    @click="removeProductVariant(index)"><i class="mdi mdi-minus"></i></button>
        </div>
        <button type="button" class="btn btn-success clonspan mt-4" tabindex="-1" @click="createProductVariant()"><i
            class="mdi mdi-plus"></i></button>
    </div>
</template>

<script>
    export default {
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
                this.$delete(this.product_variants, index);
                this.$forceUpdate();
            },
            updateProductVariant(index) {
               this.$emit('changeVariant', index, this.product_variants[index])
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
