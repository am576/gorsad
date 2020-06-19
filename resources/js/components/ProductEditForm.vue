<template>
    <form @submit.prevent="submit">
        <input type="hidden" name="_method" value="put">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" class="form-control" id="title" name="title" autocomplete="off"
                           v-model="product.title" value="123">
                    <div v-if="errors && errors.title" class="text-danger">{{errors.title[0]}}</div>
                </div>
                <div class="form-group">
                    <label for="code">Код товара</label>
                    <input type="text" class="form-control" id="code" name="code" autocomplete="off"
                           v-model="product.code">
                    <div v-if="errors && errors.code" class="text-danger">{{errors.code[0]}}</div>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <input type="text" class="form-control" id="description" name="description" autocomplete="off"
                           v-model="product.description">
                    <div v-if="errors && errors.description" class="text-danger">{{errors.description[0]}}</div>
                </div>
                <div class="form-group">
                    <label for="category_id">Категория</label>
                    <category-selector :children_only="true" :category="product.category_id"></category-selector>
                    <div v-if="errors && errors.category_id" class="text-danger">{{errors.category_id[0]}}</div>
                </div>
                <div class="form-group">
                    <label for="price">Цена</label>
                    <input type="text" class="form-control" id="price" name="price" autocomplete="off"
                           v-model="product.price">
                    <div v-if="errors && errors.price" class="text-danger">{{errors.price[0]}}</div>
                </div>
                <div class="form-group">
                    <label for="discount">Скидка</label>
                    <input type="text" class="form-control" id="discount" name="discount" autocomplete="off"
                           v-model="product.discount">
                    <div v-if="errors && errors.discount" class="text-danger">{{errors.discount[0]}}</div>
                </div>
                <div class="form-group">
                    <label for="quantity">Количество</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" autocomplete="off"
                           v-model="product.quantity">
                    <div v-if="errors && errors.quantity" class="text-danger">{{errors.quantity[0]}}</div>
                </div>
                <div class="form-group">
                    <label for="status">Статус</label>
                    <select name="status" id="status" v-model="product.status">
                        <option value="1">Активный</option>
                        <option value="0">Неактивный</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>

            <div class="col-md-4">
                <h3>Атрибуты</h3>
                <div v-if="item === 1" class="form-row" v-for="(item, index) in attribute_rows" :key="index">
                    <div class="form-group">
                        <label>Название</label>
                        <select name="attribute_id[]" @change="getAttributeValues($event.target.value, index)" v-model="product_attributes[index].id">
                            <option value="0">...</option>
                            <option v-for="attribute in attributes" :value="attribute.id">{{attribute.name}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Значение</label>
                        <select name="attribute_value_id[]" v-model="selected_values[index]">
                            <option value="0">...</option>
                            <option v-for="value in attribute_values[index]" :value="value.id">{{value.value}}</option>
                        </select>
                    </div>
                    <button v-if="index > 0" type="button" class="btn btn-danger delete" tabindex="-1" @click="removeAttributeRow(index)"><i class="mdi mdi-minus"></i></button>
                </div>

                <button type="button" class="btn btn-success clonspan" tabindex="-1" @click="createAttributeRow()"><i
                    class="mdi mdi-plus"></i></button>
            </div>
        </div>
        <div class="row product_images">
            <div class="col-md-8">
                <image-uploader :product_id="product.id" @removeImage="removeImage"></image-uploader>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            product: {},
            product_attributes: [],
            product_images: []
        },
        data() {
            return {
                images: [],
                errors: {},
                attribute_rows : [],
                attributes: [],
                attribute_values: [],
                selected_values: [],
                images_to_delete: [],
                attributes_to_delete: []
            }
        },
        methods: {
            setProductCategory(id) {
                this.product.category_id = id;
                this.getAttributesForCategory();
            },
            getAttributesForCategory()
            {
                axios.get('/api/getAttributesForCategory', {
                    params: {
                        category_id: this.product.category_id
                    }
                }).then(response => {
                    this.attributes = response.data;
                })
            },
            getAttributeValues(attribute_id, index)
            {
                axios.get('/api/getAttributeValues', {
                    params: {
                        attribute_id: attribute_id
                    }
                }).then(response => {
                    this.$set(this.attribute_values, index, response.data)
                })
            },
            setProductImages(images) {
                this.images = images;
            },
            populateAttributes()
            {
                this.getAttributesForCategory();
                if(this.product_attributes.length > 0)
                {
                    this.attributes = this.product_attributes;
                    this.attributes.forEach((attribute, index) => {
                        this.getAttributeValues(attribute.id, index);
                        this.$set(this.selected_values, index, attribute.value_id);
                        this.$set(this.attribute_rows, this.attribute_rows.length, 1);
                    })
                }
            },
            createAttributeRow()
            {
                this.$set(this.product_attributes, this.attribute_rows.length, {id:0});
                this.$set(this.attribute_rows, this.attribute_rows.length, 1);

            },
            removeAttributeRow(index)
            {
                this.$set(this.attribute_rows, index, 0);
                this.$set(this.attributes_to_delete, this.attributes_to_delete.length, this.product_attributes[index].id);
            },
            removeImage(image_id)
            {
                if(!this.images_to_delete.includes(image_id))
                {
                    this.images_to_delete.push(image_id);
                }
            },
            submit() {
                this.errors = {};
                const formData = new FormData();

                Object.keys(this.product).forEach(key => {
                    formData.append(key, this.product[key])
                });

                this.images.forEach(file => {
                    formData.append('images[]', file, file.name);
                });
                this.product_attributes.forEach(attribute => {
                    if(attribute.id)
                    {
                        formData.append('attribute_id[]', attribute.id);
                    }
                });
                this.selected_values.forEach(value => {
                    formData.append('attribute_value_id[]', value);
                });
                this.attributes_to_delete.forEach(attr_id => {
                    formData.append('attributes_to_delete[]', attr_id)
                });
                this.images_to_delete.forEach(image_id => {
                    formData.append('images_to_delete[]', image_id)
                });
                formData.append('_method', 'PUT');

                axios.post('/admin/products/' + this.product.id, formData)
                .then(response =>{
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },
        created: function () {
            this.$eventBus.$on('changeCategory', this.setProductCategory);
            this.$eventBus.$on('addImages', this.setProductImages);
            this.populateAttributes();
        }
    }
</script>
