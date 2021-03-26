<template>
    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Название</label>
                    <input type="text" class="form-control" v-model="iconset.name">
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
            <div class="col-md-6">
                <image-uploader :entity_id="iconset_id" :entity_model="'IconSet'" :entity="iconset"
                                :isSingleImage="false" :storage="'attributes/'" @removeImage="removeImage">
                </image-uploader>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            iconset_data: {},
            edit_form: false
        },
        data() {
            return {
                iconset: {},
                iconset_id : 0,
                images: [],
                images_to_delete: []
            }
        },
        methods: {
            setIconSet() {
                this.iconset = this.iconset_data;
                this.iconset_id = this.iconset.id;
            },
            submit() {
                this.errors = {};
                const formData = new FormData();

                Object.keys(this.iconset).forEach(key => {
                    formData.append(key, this.iconset[key])
                });

                formData.delete('images');

                if(this.images.length)
                {
                    this.images.forEach(file => {
                        formData.append('images[]', file, file.name);
                    });
                }

                let url = '/admin/icon_sets';

                if(this.edit_form) {
                    this.images_to_delete.forEach(image_id => {
                        formData.append('images_to_delete[]', image_id)
                    });
                    formData.append('_method', 'PUT');
                    url = '/admin/icon_sets/' + this.iconset.id
                }

                axios.post(url, formData)
                    .then(response => {
                        if(response.status == '200')
                        {
                            window.location.href = '/admin/icon_sets'
                        }
                    }).catch(error => {
                    if ([422, 500].includes(error.response.status)) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            },
            setImages(images) {
                this.images = images;
            },
            removeImage(image_id) {
                if(!this.images_to_delete.includes(image_id))
                {
                    this.images_to_delete.push(image_id);
                }
            },
        },
        created: function() {
            this.$eventBus.$on('addImages', this.setImages);
            if(this.edit_form)
                this.setIconSet();
        }
    }
</script>
