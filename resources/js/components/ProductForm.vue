<template>
    <div>
        <nav>
            <div class="nav nav-tabs product-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#product-description" role="tab" aria-controls="nav-home" aria-selected="true">Описание</a>
                <a class="nav-item nav-link" id="nav-attributes-tab" data-toggle="tab" href="#product-attributes" role="tab" aria-controls="nav-profile" aria-selected="false">Атрибуты</a>
                <a class="nav-item nav-link" id="nav-photo-tab" data-toggle="tab" href="#product-photo" role="tab" aria-controls="nav-contact" aria-selected="false">Фото</a>
                <a class="nav-item nav-link" id="nav-variants-tab" data-toggle="tab" href="#product-variants" role="tab" aria-controls="nav-contact" aria-selected="false">Варианты</a>
            </div>
        </nav>
        <form @submit.prevent="submit">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="product-description" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id">Категория</label>
                                <category-selector :children_only="true"></category-selector>
                                <div v-if="errors && errors.category_id" class="text-danger">{{errors.category_id[0]}}</div>
                            </div>
                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" class="form-control" id="title" name="title" autocomplete="off"
                                       v-model="product.title">
                                <div v-if="errors && errors.title" class="text-danger">{{errors.title[0]}}</div>
                            </div>
                            <div class="form-group" v-for="(field,index) in category_fields" :key="index">
                                <label for="title">{{field.title}}</label>
                                <input type="text" class="form-control" :id="field.name" :name="field.name" autocomplete="off"
                                       v-model="additional_info[field.name]">
                                <div v-if="errors && errors.title" class="text-danger">{{errors.title[0]}}</div>
                            </div>
                            <!--<div class="form-group">
                                <label for="code">Код товара</label>
                                <input type="text" class="form-control" id="code" name="code" autocomplete="off"
                                       v-model="product.code">
                                <div v-if="errors && errors.code" class="text-danger">{{errors.code[0]}}</div>
                            </div>-->
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
                                <ckeditor :editor="editor" :config="editorConfig" v-model="product.description"></ckeditor>
                                <div v-if="errors && errors.description" class="text-danger">{{errors.description[0]}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="product-attributes" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="col-md-8">
                        <div class="attributes-list">
                            <h3>Атрибуты</h3>
                            <div class="form-row" v-for="(product_attribute, index) in product.attributes" :key="index">
                                <div class="form-group">
                                    <label>Название</label>
                                    <select name="attribute_id[]" @change="getAttributeValues($event.target, index)" v-model="product_attribute.id">
                                        <option value="0">...</option>
                                        <option v-for="attribute in attributes" :value="attribute.id" :data-type="attribute.type">{{attribute.name}}</option>
                                    </select>
                                </div>
                                <div class="form-group" style="width:200px" v-if="product_attribute">
                                    <attribute-values :attribute_id="product_attribute.id" :type="attribute_types[index]" :index="index" :values="product_attribute.attribute_values" :selected="selected_values[index]"></attribute-values>
                                </div>
                                <button type="button" class="btn btn-danger delete" tabindex="-1"
                                        @click="removeAttributeRow(index)"><i class="mdi mdi-minus"></i></button>
                            </div>
                            <button type="button" class="btn btn-success clonspan" tabindex="-1" @click="createAttributeRow()"><i
                                class="mdi mdi-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="product-photo" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <image-uploader></image-uploader>
                </div>
                <div class="tab-pane fade" id="product-variants" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <product-variants @changeVariant="updateVariant"></product-variants>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
</template>

<script>
    import CKEditor from '@ckeditor/ckeditor5-vue';

    export default {
        components: {
            ckeditor: CKEditor.component
        },
        data() {
            return {
                editor: ClassicEditor,
                editorConfig: {
                    fontSize: {
                        options: [
                            'tiny',
                            'default',
                            'big'
                        ]
                    },
                    toolbar: [
                        'heading', 'bulletedList', 'numberedList', 'fontSize', 'undo', 'redo'
                    ],
                },
                product: {
                    attributes: [],
                    status: 1,
                    variants: []
                },
                images: [],
                errors: {},
                attribute_rows : [],
                attributes: [],
                attribute_types: [],
                category_fields: [],
                additional_info:{},
                text_options: {},
                selected_values: [],
            }
        },
        methods: {
            setProductCategory(id) {
                this.product.category_id = id;
                this.getCategoryParams();
            },
            getCategoryParams()
            {
                axios.get('/api/getCategoryParams', {
                    params: {
                        category_id: this.product.category_id
                    }
                }).then(response => {
                    this.attributes = response.data.attributes;
                    this.category_fields = JSON.parse(response.data.additional_fields);
                })
            },
            getAttributeValues(select, index)
            {
                const selected = select.options[select.options.selectedIndex].dataset;
                this.$set(this.attribute_types, index, selected.type)

                axios.get('/api/getAttributeValues', {
                    params: {
                        attribute_id: select.value
                    }
                }).then(response => {
                    this.$set(this.product.attributes[index], 'id', select.value);
                    this.$set(this.product.attributes[index], 'attribute_values', response.data);
                    if(this.attribute_types[index] === 'range') {
                        this.$set(this.product.attributes[index], 'values', [response.data[0].id,response.data[response.data.length-1].id]);
                        this.$set(this.product.attributes[index].attribute_values, 'range', [response.data[0].id,response.data[response.data.length-1].id]);
                    }
                    else if(this.attribute_types[index] === 'color') {
                        this.$set(this.product.attributes[index], 'values', []);
                    }
                    else if(this.attribute_types[index] === 'icon') {
                        this.$set(this.product.attributes[index], 'values', []);
                        axios.get('/api/getAttributeIcons', {
                            params: {
                                attribute_id: this.product.attributes[index].id
                            }
                        }).then(response => {
                            this.$set(this.product.attributes[index].attribute_values, 'icons', response.data);
                        })
                    }

                })
            },
            setAttributeValues(index, values) {
                this.$set(this.product.attributes[index], 'values', values);
                if(this.attribute_types[index] === 'color' || this.attribute_types[index] === 'text') {
                    this.$set(this.selected_values, index, values)
                }
                else if(this.attribute_types[index] === 'icon') {
                    this.$set(this.selected_values, index, values);
                    this.$set(this.product.attributes[index],'values',[values[0].icon_id])
                }
            },
            setProductImages(images) {
                this.images = images;
            },
            createAttributeRow()
            {
                this.$set(this.product.attributes, this.product.attributes.length, {})
            },
            removeAttributeRow(index)
            {
                Vue.delete(this.attribute_types, index);
                Vue.delete(this.selected_values, index);
                this.$delete(this.product.attributes, index);
                this.$forceUpdate();
            },

            updateVariant(index, variant) {
                console.log(index)
                this.$set(this.product.variants, index, variant);
            },

            submit() {
                this.errors = {};
                const formData = new FormData();

                Object.keys(this.product).forEach(key => {
                    formData.append(key, this.product[key])
                });

                formData.delete('attributes');
                formData.delete('variants');
                formData.append('additional_info', JSON.stringify(this.additional_info));
                formData.append('attributes', JSON.stringify(this.product.attributes));
                formData.append('variants', JSON.stringify(this.product.variants));
                this.images.forEach(file => {
                    formData.append('images[]', file, file.name);
                });

                axios.post('/admin/products', formData)
                .then(response =>{
                    if(response.status == 200) {
                        window.location.href = '/admin/products'
                    }
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },
        computed: {

        },
        created: function () {
            this.$eventBus.$on('changeCategory', this.setProductCategory);
            this.$eventBus.$on('addImages', this.setProductImages)
            this.$eventBus.$on('changeAttributeValue', this.setAttributeValues)
        }
    }
</script>

<style lang="scss">
    .ck-content { height:300px; }
</style>
