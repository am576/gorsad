<template>
    <div class="mt-3">
        <nav>
            <div class="nav nav-tabs product-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab"
                   href="#product-description" role="tab" aria-controls="nav-home" aria-selected="true">Описание</a>
                <a class="nav-item nav-link" id="nav-attributes-tab" data-toggle="tab" href="#product-attributes"
                   role="tab" aria-controls="nav-profile" aria-selected="false">Атрибуты</a>
                <a class="nav-item nav-link" id="nav-photo-tab" data-toggle="tab" href="#product-photo" role="tab"
                   aria-controls="nav-contact" aria-selected="false">Фото</a>
                <a class="nav-item nav-link" id="nav-variants-tab" data-toggle="tab" href="#product-variants" role="tab"
                   aria-controls="nav-contact" aria-selected="false">Варианты</a>
            </div>
        </nav>
        <div class="admin-form">
            <form @submit.prevent="submit" class="d-flex flex-column">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="product-description" role="tabpanel"
                         aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Категория</label>
                                    <category-selector :children_only="true"></category-selector>
                                    <div v-if="errors && errors.category_id" class="text-danger">
                                        {{errors.category_id[0]}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input type="text" class="form-control" id="title" name="title" autocomplete="off"
                                           v-model="product.title">
                                    <div v-if="errors && errors.title" class="text-danger">{{errors.title[0]}}</div>
                                </div>
                                <div class="form-group">
                                    <label for="title_lat">Название латинское</label>
                                    <input type="text" class="form-control" id="title_lat" name="title_lat"
                                           autocomplete="off"
                                           v-model="product.title_lat">
                                    <div v-if="errors && errors.title_lat" class="text-danger">{{errors.title_lat[0]}}
                                    </div>
                                </div>
                                <!--<div class="form-group" v-for="(field,index) in category_fields" :key="index">
                                    <label for="title">{{field.title}}</label>
                                    <input type="text" class="form-control" :id="field.name" :name="field.name" autocomplete="off"
                                           v-model="additional_info[field.name]">
                                    <div v-if="errors && errors.title" class="text-danger">{{errors.title[0]}}</div>
                                </div>-->
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
                                    <select name="status" id="status" class="form-control" v-model="product.status">
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
                        <div class="col-md-9">
                            <div class="attributes-list">
                                <div class="form-row" v-for="(product_attribute, index) in product.attributes"
                                     :key="index">
                                    <div class="form-group">
                                        <select name="attribute_id[]" @change="getAttributeValues($event.target, index)"
                                                v-model="product_attribute.id">
                                            <option value="0">...</option>
                                            <option v-for="attribute in attributes" :value="attribute.id"
                                                    :data-type="attribute.type">{{attribute.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group" v-if="product_attribute">
                                        <attribute-values :attribute_id="product_attribute.id"
                                                          :type="product_attribute.type" :index="index"
                                                          :values="product_attribute.attribute_values"
                                                          :selected_values="product_attribute.values"></attribute-values>
                                    </div>
                                    <button type="button" class="btn btn-danger delete" tabindex="-1"
                                            @click="removeAttributeRow(index)"><i class="mdi mdi-minus mdi-24px"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="w-100 d-flex justify-content-end">
                                <button type="button" class="btn btn-success clonspan d-flex align-items-center"
                                        tabindex="-1" @click="createAttributeRow()"><i
                                    class="mdi mdi-plus mdi-24px mr-1"></i>Добавить атрибут
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="product-photo" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <image-uploader></image-uploader>
                    </div>
                    <div class="tab-pane fade" id="product-variants" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <product-variants @changeVariant="updateVariant"
                                          @removeVariant="removeVariant"></product-variants>
                    </div>
                </div>
                <div class="w-100 d-flex justify-content-center">
                    <button type="submit" class="btn btn-rounded border-2 btn-lg btn-blue" style="margin-top: 5rem;">Создать товар</button>
                </div>
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
                    status: 0,
                    variants: []
                },
                images: [],
                errors: {},
                attributes: [],
                category_fields: [],
                additional_info: {},
            }
        },
        methods: {
            setProductCategory(id) {
                this.product.category_id = id;
                this.getCategoryParams();
            },
            getCategoryParams() {
                axios.get('/api/getCategoryParams', {
                    params: {
                        category_id: this.product.category_id
                    }
                }).then(response => {
                    this.attributes = response.data.attributes;
                    this.category_fields = JSON.parse(response.data.additional_fields);
                })
            },
            getAttributeValues(select, index) {
                const selected = select.options[select.options.selectedIndex].dataset;

                axios.get('/api/getAttributeValues', {
                    params: {
                        attribute_id: select.value
                    }
                }).then(response => {
                    let attribute = {
                        'id': select.value,
                        'type': selected.type,
                        'values': []
                    };
                    if (selected.type === 'range') {
                            attribute.attribute_values = [response.data.attribute_values[0].value, response.data.attribute_values[1].value];
                            this.$set(this.product.attributes, index, attribute)
                            this.$eventBus.$emit('initRangeValues', attribute.attribute_values);
                        }
                        else {
                            attribute.attribute_values = response.data.attribute_values;
                        this.$set(this.product.attributes, index, attribute)
                        }

                })
            },
            setAttributeValues(index, values) {
                console.log(values)
                this.product.attributes[index].values = values;
                // this.$set(this.product.attributes[index], 'values', values)
            },
            setProductImages(images) {
                this.images = images;
            },
            createAttributeRow() {
                this.$set(this.product.attributes, this.product.attributes.length, {})
            },
            removeAttributeRow(index) {
                this.$delete(this.product.attributes, index);
                this.$forceUpdate();
            },

            updateVariant(index, variant) {
                this.$set(this.product.variants, index, variant);
            },

            removeVariant(index) {
                this.$delete(this.product.variants, index);
            },

            submit() {
                this.errors = {};
                const formData = new FormData();

                if (!this.product.hasOwnProperty('title_lat') || this.product.title_lat === '') this.product.title_lat = this.product.title;
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
                    .then(response => {
                        if (response.status == 200) {
                            window.location.href = '/admin/products'
                        }
                    }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },
        computed: {},
        created: function () {
            this.$eventBus.$on('changeCategory', this.setProductCategory);
            this.$eventBus.$on('addImages', this.setProductImages)
            this.$eventBus.$on('changeAttributeValue', this.setAttributeValues)
        }
    }
</script>

<style lang="scss">
    .ck-content {
        height: 300px;
    }
</style>
