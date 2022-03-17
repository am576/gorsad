<template>
    <div>
        <form @submit.prevent="submit">
            <v-overlay :value="overlay">
                <p class="display-4 d-inline">Сохранение...</p>
                <v-progress-circular indeterminate size="64"></v-progress-circular>
            </v-overlay>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control" id="name" autocomplete="off" required v-model="service_group.name">
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <ckeditor :editor="editor" :config="editorConfig" v-model="service_group.description"></ckeditor>
                        <div v-if="errors && errors.description" class="text-danger">{{errors.description[0]}}</div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="!is_edit"><image-uploader></image-uploader></div>
            <div class="row" v-if="is_edit">
                <image-uploader :isSingleImage="true" :entity="service_group" :entity_id="service_group.id" :entity_model="'ServiceGroup'"
                                @removeImage="removeImage" :storage="'service_groups/'"></image-uploader>
            </div>
            <button type="submit" class="btn btn-primary">{{submitCaption}}</button>
        </form>
    </div>
</template>

<script>
    import CKEditor from '@ckeditor/ckeditor5-vue';

    export default {
        components: {
            ckeditor: CKEditor.component
        },
        props: {
            service_group_data: null,
            is_edit: false,
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
                service_group : {},
                errors: {},
                images: [],
                images_to_delete: [],
                overlay: false,
            }
        },
        methods: {

            setImages(images) {
                this.images = images;
            },
            submit() {
                this.overlay = true;
                this.errors = {};
                const formData = new FormData();

                let form_action = '/admin/service_groups/';

                Object.keys(this.service_group).forEach(key => {
                    formData.append(key, this.service_group[key])
                });

                formData.delete('images');
                if(this.images.length)
                {
                    this.images.forEach(file => {
                        formData.append('images[]', file, file.name);
                    });
                }

                if(this.is_edit) {
                    form_action = form_action + this.service_group.id;
                    formData.append('_method', 'PUT');
                    this.images_to_delete.forEach(image_id => {
                        formData.append('images_to_delete[]', image_id)
                    });
                }

                axios.post(form_action, formData)
                    .then(response =>{
                        if(response.status == 200) {
                            window.location.href = '/admin/service_groups'
                        }
                    }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        this.overlay = false;
                    }
                });
            },
            removeImage(image_id)
            {
                if(!this.images_to_delete.includes(image_id))
                {
                    this.images_to_delete.push(image_id);
                }
            },
        },
        computed: {
            submitCaption() {
                return this.is_edit ? 'Сохранить' : 'Создать'
            }
        },
        created() {
            if(this.service_group_data !== undefined) {
                this.service_group = this.service_group_data;
            }
            this.$eventBus.$on('addImages', this.setImages)
        }
    }
</script>
<style lang="scss" scoped>
    .images-container {
        width: 100% !important;
    }
    .overlay {
        opacity: 0.46;
        background-color: rgb(33, 33, 33);
        border-color: rgb(33, 33, 33);
    }
</style>
