<template>
    <div class="mt-3">
        <nav>
            <div class="nav nav-tabs product-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#product-description" role="tab" aria-controls="nav-home" aria-selected="true">Описание</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#product-attributes" role="tab" aria-controls="nav-profile" aria-selected="false">Атрибуты</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#product-photo" role="tab" aria-controls="nav-contact" aria-selected="false">Фото</a>
                <a class="nav-item nav-link" id="nav-variants-tab" data-toggle="tab" href="#product-variants" role="tab" aria-controls="nav-contact" aria-selected="false">Варианты</a>
            </div>
        </nav>
        <div class="admin-form">
            <form class="product-edit-form" @submit.prevent="submit">
                <v-overlay :value="overlay" :z-index="10000">
                    <p class="display-4 d-inline">Сохранение...</p>
                    <v-progress-circular indeterminate size="64"></v-progress-circular>
                </v-overlay>
                <input type="hidden" name="_method" value="put">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="product-description" role="tabpanel"
                         aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Категория</label>
                                    <category-selector :children_only="true"
                                                       :category="product.category_id"></category-selector>
                                    <div v-if="errors && errors.category_id" class="text-danger">
                                        {{errors.category_id[0]}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input type="text" class="form-control" id="title" name="title" autocomplete="off"
                                           v-model="product.title" value="123">
                                    <div v-if="errors && errors.title" class="text-danger">{{errors.title[0]}}</div>
                                </div>
                                <div class="form-group">
                                    <label for="title">Название латинское</label>
                                    <input type="text" class="form-control" id="title_lat" name="title_lat"
                                           autocomplete="off"
                                           v-model="product.title_lat" value="123">
                                    <div v-if="errors && errors.title_lat" class="text-danger">{{errors.title_lat[0]}}
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <label for="code">Код товара</label>
                                    <input type="text" class="form-control" id="code" name="code" autocomplete="off"
                                           v-model="product.code">
                                    <div v-if="errors && errors.code" class="text-danger">{{errors.code[0]}}</div>
                                </div>-->
                                <!--<div class="form-group" v-for="(field,index) in category_fields" :key="index">
                                    <label for="title">{{field.title}}</label>
                                    <input type="text" class="form-control"  :name="field.name" autocomplete="off"
                                           v-model="additional_info[field.name]">
                                    <div v-if="errors && errors.title" class="text-danger">{{errors.title[0]}}</div>
                                </div>-->
                                <div class="form-group">
                                    <label for="price">Цена</label>
                                    <input type="text" class="form-control" id="price" name="price" autocomplete="off"
                                           v-model="product.price">
                                    <div v-if="errors && errors.price" class="text-danger">{{errors.price[0]}}</div>
                                </div>
                                <div class="form-group">
                                    <label for="discount">Скидка</label>
                                    <input type="text" class="form-control" id="discount" name="discount"
                                           autocomplete="off"
                                           v-model="product.discount">
                                    <div v-if="errors && errors.discount" class="text-danger">{{errors.discount[0]}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Количество</label>
                                    <input type="text" class="form-control" id="quantity" name="quantity"
                                           autocomplete="off"
                                           v-model="product.quantity">
                                    <div v-if="errors && errors.quantity" class="text-danger">{{errors.quantity[0]}}
                                    </div>
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
                                    <ckeditor :editor="editor" :config="editorConfig"
                                              v-model="product.description"></ckeditor>
                                    <div v-if="errors && errors.description" class="text-danger">
                                        {{errors.description[0]}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="product-attributes" role="tabpanel"
                         aria-labelledby="nav-profile-tab">
                        <div class="col-md-8">
                            <div class="attributes-list">
                                <div class="form-row" v-for="(attribute, index) in attrs" :key="index">
                                    <div class="form-group" data-app>
                                        <select name="attribute_id[]" @change="getAttributeValues($event.target, index)"
                                                v-model="attrs[index].id" :disabled="isSaved(attribute)">
                                            <option value="0">...</option>
                                            <option v-for="attribute in attributes" :data-type="attribute.type"
                                                    :value="attribute.id">{{attribute.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="width:300px">
                                        <attribute-values :attribute_id="attrs[index].id" :type="attrs[index].type"
                                                          :index="index" :selected_values="attrs[index].values"
                                                          :values="attrs[index].attribute_values"></attribute-values>
                                    </div>
                                    <button type="button" class="btn btn-danger delete" tabindex="-1"
                                            @click="removeAttributeRow(index)"><i class="mdi mdi-minus"></i></button>
                                </div>
                                <button type="button" class="btn btn-success  clonspan" tabindex="-1"
                                        @click="createAttributeRow()"><i
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
                    <div class="tab-pane fade" id="product-variants" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <product-variants :product="product" @changeVariant="updateVariant"
                                          @removeVariant="removeVariant"></product-variants>
                    </div>
                </div>
                <button type="button" @click="submit" class="btn btn-primary white--text" :disabled="isSubmitting">
                    Сохранить
                </button>
            </form>
        </div>
    </div>
</template>

<script>
    import CKEditor from '@ckeditor/ckeditor5-vue';

    export default {
        components: {
            ckeditor: CKEditor.component
        },
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
                images: [],
                errors: {},
                attributes: [],
                attrs:[],
                images_to_delete: [],
                attributes_to_delete: [],
                category_fields: [],
                additional_info:{},
                overlay: false,
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
                isSubmitting: false
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
                    this.category_fields = JSON.parse(response.data.additional_fields);
                })
            },
            getAttributeValues(select, index)
            {
                const selected = select.options[select.options.selectedIndex].dataset;
                this.$set(this.attrs[index], 'type', )
                axios.get('/api/getAttributeValues', {
                    params: {
                        attribute_id: select.value
                    }
                }).then(response => {
                    this.$set(this.attrs, index, {
                        'id': select.value,
                        'type': selected.type,
                        'attribute_values': response.data.attribute_values,
                        'values': []
                    })
                    if(selected.type === 'range') {
                        this.$set(this.attrs[index], 'attribute_values', [response.data.attribute_values[0].value, response.data.attribute_values[1].value])
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
                })
            },

            setAttributeValues(index, values) {
                this.$set(this.attrs[index], 'values', values);
            },
            createAttributeRow()
            {
                this.$set(this.attrs, this.attrs.length, {})
            },
            removeAttributeRow(index)
            {
                this.$set(this.attributes_to_delete, this.attributes_to_delete.length, this.attrs[index].id);
                this.$delete(this.attrs, index);
            },

            updateVariant(index, variant) {
                this.$set(this.product.variants, index, variant);
            },

            removeVariant(index) {
                this.$delete(this.product.variants, index);
            },

            removeImage(image_id)
            {
                if(!this.images_to_delete.includes(image_id))
                {
                    this.images_to_delete.push(image_id);
                }
            },
            submit() {
                this.isSubmitting = true;
                this.overlay = true;
                this.errors = {};
                const formData = new FormData();

                Object.keys(this.product).forEach(key => {
                    formData.append(key, this.product[key])
                });

                formData.delete('images');
                formData.delete('variants');
                if(this.images.length)
                {
                    this.images.forEach(file => {
                        formData.append('images[]', file, file.name);
                    });
                }

                let attributes_to_save = []
                this.attrs.forEach(attribute => {
                    attributes_to_save.push(
                        {
                            'id': attribute.id,
                            'values': attribute.values
                        })
                })
                formData.append('variants', JSON.stringify(this.product.variants));
                formData.append('additional_info', JSON.stringify(this.additional_info));
                formData.append('attributes', JSON.stringify(this.attrs));

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
                    this.isSubmitting = false;
                    if ([422, 500].includes(error.response.status)) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            },
            isSaved(attribute) {
                return attribute.hasOwnProperty('group_id');
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
    .ck-content { height:300px; }

</style>
