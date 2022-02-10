<template>
    <div>
        <form>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control" id="name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="place">Место</label>
                        <input type="text" class="form-control" id="place" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Координаты</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control" id="long" autocomplete="off">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="lat" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area">Площадь</label>
                        <input type="text" class="form-control" id="area" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="client">Заказчик</label>
                        <input type="text" class="form-control" id="client" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="doneby">Исполнитель</label>
                        <input type="text" class="form-control" id="doneby" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="plants">Список растений</label>
                        <v-select :options="options" label="title" @search="onSearch" v-model="selectedOption" :filterable="false" @search:blur="clearSearch" @option:selected="addPlant">
                            <template slot="no-options">
                                быстрый поиск растений...
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
                            @tags-changed="newTags => project_plants = newTags"
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
            <div class="row"><image-uploader></image-uploader></div>
        </form>
    </div>
</template>

<script>
    import CKEditor from "@ckeditor/ckeditor5-vue";

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
                project: {
                    plants: []
                },
                images: [],
                options: [],
                selectedOption: {},
                project_plants: [],
                tag: ''
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
                        text:this.selectedOption.title,
                        id: this.selectedOption.id
                    }
                    this.project.plants.push(this.selectedOption.id);
                    this.project_plants.push(new_plant);

                }
            },
            setImages(images) {
                this.images = images;
            },
        },
        created() {
            this.$eventBus.$on('addImages', this.setImages)
        }
    }
</script>
<style lang="scss" scoped>
    .images-container {
        width: 100% !important;
    }
</style>
