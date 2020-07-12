<template>
    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Название</label>
                    <input type="text" class="form-control" v-model="category.title">
                </div>
                <div class="form-group">
                    <label>Принадлежит</label>
                    <category-selector :select_name="'parent_id'" :owner_id="category.id ? category.id : 0" :parent_id="category.parent_id" :except_self="true"></category-selector>
                </div>
                <div class="form-group">
                    <label>Описание</label>
                    <input type="text" class="form-control" v-model="category.description">
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
            <div class="col-md-6">
                <image-uploader :entity_id="category_id" :entity_model="'Category'" :entity="category"
                                :isSingleImage="true" :storage="'categories/'" @removeImage="removeImage">

                </image-uploader>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            category_data: {},
            edit_form: false,
        },
        data() {
            return {
                category: {},
                images: [],
                errors: {},
                category_id: 0,
                images_to_delete: []
            }
        },
        methods: {
            setCategory() {
              this.category = this.category_data;
              this.category_id = this.category.id;
            },
            setCategoryImages(images) {
                this.images = images;
            },
            setParentCategory(id) {
                this.category.parent_id = id;
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

                Object.keys(this.category).forEach(key => {
                    formData.append(key, this.category[key])
                });

                formData.delete('images');
                if(this.images.length)
                {
                    this.images.forEach(file => {
                        formData.append('images[]', file, file.name);
                    });
                }

                let url = '/admin/categories';

                if(this.edit_form) {
                    this.images_to_delete.forEach(image_id => {
                        formData.append('images_to_delete[]', image_id)
                    });
                    formData.append('_method', 'PUT');
                    url = '/admin/categories/' + this.category.id
                }

                axios.post(url, formData)
                    .then(response => {
                        if(response.status == '200')
                        {
                            window.location.href = '/admin/categories'
                        }
                    }).catch(error => {
                    if ([422, 500].includes(error.response.status)) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },
        created() {
            this.$eventBus.$on('changeCategory', this.setParentCategory);
            this.$eventBus.$on('addImages', this.setCategoryImages);
            if(this.edit_form)
                this.setCategory();
        }
    }
</script>
