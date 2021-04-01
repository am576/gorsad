<template>
    <div>

        <nav>
            <div class="nav nav-tabs product-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#product-description" role="tab" aria-controls="nav-home" aria-selected="true">Описание</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#product-attributes" role="tab" aria-controls="nav-profile" aria-selected="false">Атрибуты</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#product-photo" role="tab" aria-controls="nav-contact" aria-selected="false">Фото</a>
            </div>
        </nav>

        <form class="product-edit-form" @submit.prevent="submit">
            <v-overlay :value="overlay">
                <p class="display-4 d-inline">Сохранение...</p>
                <v-progress-circular indeterminate size="64"></v-progress-circular>
            </v-overlay>
            <input type="hidden" name="_method" value="put">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="product-description" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" class="form-control" id="title" name="title" autocomplete="off"
                                       v-model="product.title" value="123">
                                <div v-if="errors && errors.title" class="text-danger">{{errors.title[0]}}</div>
                            </div>
                            <!--<div class="form-group">
                                <label for="code">Код товара</label>
                                <input type="text" class="form-control" id="code" name="code" autocomplete="off"
                                       v-model="product.code">
                                <div v-if="errors && errors.code" class="text-danger">{{errors.code[0]}}</div>
                            </div>-->

                            <div class="form-group">
                                <label for="category_id">Категория</label>
                                <category-selector :children_only="true" :category="product.category_id"></category-selector>
                                <div v-if="errors && errors.category_id" class="text-danger">{{errors.category_id[0]}}</div>
                            </div>
                            <div class="form-group" v-for="(field,index) in category_fields" :key="index">
                                <label for="title">{{field.title}}</label>
                                <input type="text" class="form-control"  :name="field.name" autocomplete="off"
                                       v-model="additional_info[field.name]">
                                <div v-if="errors && errors.title" class="text-danger">{{errors.title[0]}}</div>
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
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="description">Описание</label>
                                <input type="text" class="form-control" id="description" name="description" autocomplete="off"
                                       v-model="product.description">
                                <div v-if="errors && errors.description" class="text-danger">{{errors.description[0]}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="product-attributes" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="col-md-8">
                        <div class="attributes-list">
                            <h3>Атрибуты</h3>
                            <div class="form-row" v-for="(item, index) in attrs" :key="index">
                                <div class="form-group" data-app>
                                    <label>Название</label>
                                    <select name="attribute_id[]" @change="getAttributeValues($event.target, index)" v-model="product_attributes[index].id">
                                        <option value="0">...</option>
                                        <option v-for="attribute in attributes" :data-type="attribute.type" :value="attribute.id">{{attribute.name}}</option>
                                    </select>
                                </div>
                                <div class="form-group" style="width:200px">
                                    <attribute-values :attribute_id="product_attributes[index].attribute_id" :type="product_attributes[index].type" :index="index" :values="attribute_values[index]"></attribute-values>
                                </div>
                                <button type="button" class="btn btn-danger delete" tabindex="-1" @click="removeAttributeRow(index)"><i class="mdi mdi-minus"></i></button>
                            </div>
                            <button type="button" class="btn btn-success  clonspan" tabindex="-1" @click="createAttributeRow()"><i
                                class="mdi mdi-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="product-photo" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="row product_images">
                        <div class="col-md-8">
                            <image-uploader :entity="product" :entity_id="product.id" :entity_model="'Product'"
                                            @removeImage="removeImage" :storage="'products/'"></image-uploader>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" @click="submit" class="btn btn-primary white--text">Сохранить</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            product: {
                attributes:{}
            },
            product_attributes: {
                type: Array,
                default:  function() {return []}
            },
            product_images: []
        },
        data() {
            return {
                new_attribute_values: [],
                images: [],
                errors: {},
                attribute_rows : [],
                attributes: [],
                attrs:[],
                attribute_values: [],
                selected_values: [],
                images_to_delete: [],
                attributes_to_delete: [],
                category_fields: [],
                additional_info:{},
                overlay: false,
            }
        },
        methods: {
            setProductCategory(id) {
                if(confirm('Смена категории удалит все созданные атрибуты. Продолжить?'))
                {
                    this.product.category_id = id;
                    this.getAttributesForCategory();
                }
            },
            getCategoryParams()
            {
                axios.get('/api/getCategoryParams', {
                    params: {
                        category_id: this.product.category_id
                    }
                }).then(response => {
                    this.category_fields = response.data.additional_fields;
                })
            },
            getAttributesForCategory()
            {

            },
            getAttributeValues(select, index)
            {
                const selected = select.options[select.options.selectedIndex].dataset;
                this.$set(this.product_attributes[index], 'type', selected.type)
                this.$set(this.new_attribute_values[index], 'id', select.value)
                axios.get('/api/getAttributeValues', {
                    params: {
                        attribute_id: select.value
                    }
                }).then(response => {
                    this.$set(this.attribute_values, index, response.data);
                    if(selected.type === 'range') {
                        this.$set(this.new_attribute_values[index], 'values', [response.data[0].id,response.data[response.data.length-1].id]);
                        this.$eventBus.$emit('getAttributeValues', [this.attribute_values[index][0],this.attribute_values[index][this.attribute_values[index].length-1]]);
                    }
                    else if(selected.type === 'color') {
                        this.$set(this.new_attribute_values[index], 'values', []);
                        this.$eventBus.$emit('getAttributeValues', this.attribute_values[index]);
                    }
                    else if(selected.type === 'icon') {
                        this.$set(this.product.attributes[index], 'values', []);
                        axios.get('/api/getAttributeIcons', {
                            params: {
                                attribute_id: this.product.attributes[index].id
                            }
                        }).then(response => {
                            this.$eventBus.$emit('getAttributeValues', {'values':this.attribute_values[index],'options':response.data},);
                        })
                    }
                })
            },
            setProductImages(images) {
                this.images = images;
            },
            populateAttributes() {
                axios.get('/api/getAttributesForCategory', {
                    params: {
                        category_id: this.product.category_id
                    }
                }).then(response => {
                    this.attributes = response.data;
                    if (this.attrs.length > 0) {
                        this.attrs.forEach((attribute, index) => {
                            this.setDefaultAttributeValues(attribute,index);
                            axios.get('/api/getAttributeValues', {
                                params: {
                                    attribute_id: attribute.attribute_id
                                }
                            }).then(values => {
                                if (attribute.type === 'range') {
                                    this.$set(this.attribute_values, index, values.data);
                                    this.$eventBus.$emit('setAttributeValues', attribute.attribute_id, attribute.selected_values);
                                }
                                else if(attribute.type === 'color') {
                                    this.$set(this.attribute_values, index, values.data);
                                    this.$eventBus.$emit('setAttributeValues', attribute.attribute_id, {
                                        'colors' : values.data,
                                        'selected': attribute.selected_values
                                    });
                                }
                                else if(attribute.type === 'icon') {
                                    axios.get('/api/getAttributeIcons', {
                                        params: {
                                            attribute_id: attribute.attribute_id
                                        }
                                    }).then(icons => {
                                        icons.data.forEach(icon => {
                                            if(icon.icon_id === attribute.selected_values[0].icon_id){
                                                this.$eventBus.$emit('setAttributeValues', attribute.attribute_id, {
                                                    'values': [icon, values.data],
                                                    'options': icons.data
                                                });
                                            }
                                        })
                                    })
                                }
                            })
                        })
                    }
                })
            },
            setDefaultAttributeValues(attribute, index) {
                this.$set(this.new_attribute_values, index, {})
                this.$set(this.new_attribute_values[index], 'id', attribute.attribute_id)
                let values = [];
                attribute.selected_values.forEach(value => {
                    values.push(value.id)
                })
                this.setAttributeValues(index, values)
            },
            setAttributeValues(index, values) {
                if(this.product_attributes[index] === 'range' || 'color' || 'icon') {
                    this.$set(this.new_attribute_values[index], 'values', values);
                }
            },
            createAttributeRow()
            {
                this.$set(this.new_attribute_values, this.attrs.length, {})
                this.$set(this.product_attributes, this.attrs.length, {})
            },
            removeAttributeRow(index)
            {
                this.$set(this.attributes_to_delete, this.attributes_to_delete.length, this.product_attributes[index].attribute_id);
                Vue.delete(this.product_attributes, index);
                Vue.delete(this.new_attribute_values, index);

            },
            removeImage(image_id)
            {
                if(!this.images_to_delete.includes(image_id))
                {
                    this.images_to_delete.push(image_id);
                }
            },
            submit() {
                this.overlay = true;
                this.errors = {};
                const formData = new FormData();

                Object.keys(this.product).forEach(key => {
                    formData.append(key, this.product[key])
                });

                formData.delete('images');
                if(this.images.length)
                {
                    this.images.forEach(file => {
                        formData.append('images[]', file, file.name);
                    });
                }
                formData.append('additional_info', JSON.stringify(this.additional_info));
                formData.append('attributes', JSON.stringify(this.new_attribute_values));

                this.attributes_to_delete.forEach(attr_id => {
                    formData.append('attributes_to_delete[]', attr_id)
                });
                this.images_to_delete.forEach(image_id => {
                    formData.append('images_to_delete[]', image_id)
                });
                formData.append('_method', 'PUT');

                axios.post('/admin/products/' + this.product.id, formData)
                .then(response => {
                    this.overlay = false;
                    if(response.status == '200')
                    {
                        window.location.href = '/admin/products'
                    }
                }).catch(error => {
                    this.overlay = false;
                    if ([422, 500].includes(error.response.status)) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },
        created: function () {
            this.additional_info = JSON.parse(this.product.additional_info)
            this.attrs = this.product_attributes;
            this.$eventBus.$on('changeCategory', this.setProductCategory);
            this.$eventBus.$on('addImages', this.setProductImages);
            this.$eventBus.$on('changeAttributeValue', this.setAttributeValues);
            this.populateAttributes();
            this.getCategoryParams();
        }
    }
</script>
<style lang="scss" scoped>
    .product-edit-form {

        .overlay {
            opacity: 0.46;
            background-color: rgb(33, 33, 33);
            border-color: rgb(33, 33, 33);
        }
    }

</style>
