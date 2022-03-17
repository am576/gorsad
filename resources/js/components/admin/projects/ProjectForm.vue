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
                        <input type="text" class="form-control" id="name" autocomplete="off" required v-model="project.name">
                    </div>
                    <div class="form-group">
                        <label for="place">Место</label>
                        <input type="text" class="form-control" id="place" autocomplete="off" v-model="project.place">
                    </div>
                    <div class="form-group">
                        <label>Координаты</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control" id="long" autocomplete="off" v-model="project.lat">
                                <div v-if="errors && errors.long" class="text-danger">{{errors.lat[0]}}</div>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="lat" autocomplete="off" v-model="project.long">
                                <div v-if="errors && errors.lat" class="text-danger">{{errors.long[0]}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area">Площадь</label>
                        <input type="text" class="form-control" id="area" autocomplete="off" v-model="project.area">
                        <div v-if="errors && errors.area" class="text-danger">{{errors.area[0]}}</div>
                    </div>
                    <div class="form-group">
                        <label for="client">Заказчик</label>
                        <input class="form-control" id="client" autocomplete="off" v-model="project.client">
                    </div>
                    <div class="form-group">
                        <label for="doneby">Исполнитель</label>
                        <input class="form-control" id="doneby" autocomplete="off" v-model="project.doneby">
                    </div>
                    <div class="form-group">
                        <label>Список растений</label>
                        <v-select :options="options" label="title" @search="onSearch" v-model="selectedOption" :filterable="false" @search:blur="clearSearch" @option:selected="addPlant">
                            <template slot="no-options">
                                введите название
                            </template>
                            <template slot="option" slot-scope="option">
                                <div class="d-flex justify-content-between">
                                    <p>{{ option.title }}</p>
                                </div>
                            </template>
                            <template slot="selected-option" slot-scope="option">
                                <div class="selected d-center">
                                    {{ option.title }}
                                </div>
                            </template>
                        </v-select>
                        <vue-tags-input
                            v-model="tag"
                            :tags="project_plants"
                            :avoid-adding-duplicates="true"
                            :placeholder="''"
                            @tags-changed="changeTags"
                        />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Описание</label>
                        <ckeditor :editor="editor" :config="editorConfig" v-model="project.description"></ckeditor>
                    </div>
                </div>
            </div>
            <div class="row" v-if="!is_edit"><image-uploader></image-uploader></div>
            <div class="row" v-if="is_edit">
                <image-uploader :entity="project" :entity_id="project.id" :entity_model="'Project'"
                                @removeImage="removeImage" :storage="'projects/'"></image-uploader>
            </div>
            <button type="submit" class="btn btn-primary">{{submitCaption}}</button>
        </form>
    </div>
</template>

<script>
    import CKEditor from "@ckeditor/ckeditor5-vue";

    export default {
        components: {
            ckeditor: CKEditor.component
        },
        props: {
            project_data: null,
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
                errors: {},
                project: {
                    plants: []
                },
                images: [],
                options: [],
                selectedOption: {},
                project_plants: [],
                images_to_delete: [],
                tag: '',
                overlay: false,
            }
        },
        methods: {
            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.search(search, loading, this);
                }
            },
            search(search, loading, vm)  {
                axios({
                    method: 'GET',
                    url:`/api/searchProduct`,
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded'
                    },
                    params: {
                        q: search
                    }})
                    .then(res => {
                        this.options = res.data;
                        loading(false);
                    })
            },
            clearSearch() {

            },
            addPlant() {
                if(!this.project.plants.includes(this.selectedOption.id)) {
                    let new_plant = {
                        id: this.selectedOption.id,
                        text:this.selectedOption.title
                    }
                    this.project.plants.push(this.selectedOption.id);
                    this.project_plants.push(new_plant);
                }
            },
            changeTags(newTags) {
                this.project.plants.splice(0, this.project.plants.length);
                newTags.forEach(tag => {
                    this.project.plants.push(tag.id);
                })
                this.project_plants = newTags;
            },
            setImages(images) {
                this.images = images;
            },
            submit() {
                this.overlay = true;
                this.errors = {};
                const formData = new FormData();

                let form_action = '/admin/projects/';
                this.project.description = this.project.description.substring(3, this.project.description.length - 4);

                Object.keys(this.project).forEach(key => {
                    formData.append(key, this.project[key])
                });
                formData.delete('plants');
                formData.append('plants', this.project.plants.join(','));

                formData.delete('images');
                if(this.images.length)
                {
                    this.images.forEach(file => {
                        formData.append('images[]', file, file.name);
                    });
                }

                if(this.is_edit) {
                    form_action = '/admin/projects/' + this.project.id;
                    formData.append('_method', 'PUT');
                    this.images_to_delete.forEach(image_id => {
                        formData.append('images_to_delete[]', image_id)
                    });
                }

                axios.post(form_action, formData)
                    .then(response =>{
                        if(response.status == 200) {
                            window.location.href = '/admin/projects'
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
            if(this.project_data !== undefined) {
                this.project = this.project_data;
                this.project_plants = this.project.plants;
                this.project.plants = []
                this.project_plants.forEach(plant => {
                    this.project.plants.push(plant.id)
                })
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
