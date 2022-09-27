<template>
    <div class="admin-form">
        <form @submit.prevent="submit" class="d-flex flex-column">
            <v-overlay :value="overlay">
                <p class="display-4 d-inline">Сохранение...</p>
                <v-progress-circular indeterminate size="64"></v-progress-circular>
            </v-overlay>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control" id="name" autocomplete="off" required v-model="service.name">
                        <div v-if="errors && errors.name" class="text-danger">{{errors.name[0]}}</div>
                    </div>
                    <div class="form-group">
                        <label for="group_id">Группа</label>
                        <select class="form-control" name="group_id" id="group_id" v-model="service.group_id">
                            <option value="0">...</option>
                            <option v-for="group in groups" :value="group.id" :key="group.id">{{group.name}}</option>
                        </select>
                        <div v-if="errors && errors.group_id" class="text-danger">{{errors.group_id[0]}}</div>
                    </div>
                    <div class="form-group">
                        <label for="price">Цена</label>
                        <input type="text" class="form-control" id="price" autocomplete="off" required v-model="service.price">
                        <div v-if="errors && errors.price" class="text-danger">{{errors.price[0]}}</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Описание</label>
                        <ckeditor :editor="editor" :config="editorConfig" v-model="service.description"></ckeditor>
                        <div v-if="errors && errors.description" class="text-danger">{{errors.description[0]}}</div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-rounded btn-blue border-2">{{submitCaption}}</button>
            </div>
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
            service_data: null,
            is_edit: false,
        },
        data() {
            return {
                service : {},
                groups: Array,
                errors: {},
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
            }
        },
        methods: {
            getServiceGroups() {
                axios.get('/api/getServiceGroups')
                    .then((response) => {
                        this.groups = response.data;
                    })
            },
            submit() {
                this.overlay = true;
                this.errors = {};
                const formData = new FormData();

                let form_action = '/admin/services/';

                Object.keys(this.service).forEach(key => {
                    formData.append(key, this.service[key])
                });

                if(this.is_edit) {
                    form_action = '/admin/services/' + this.service.id;
                    formData.append('_method', 'PUT');
                }

                axios.post(form_action, formData)
                    .then(response =>{
                        if(response.status == 200) {
                            window.location.href = '/admin/services'
                        }
                    }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        this.overlay = false;
                    }
                });
            },
        },
        computed: {
            submitCaption() {
                return this.is_edit ? 'Сохранить' : 'Создать'
            }
        },
        created() {
            this.getServiceGroups();
            if(this.service_data !== undefined) {
                this.service = this.service_data;
            }
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
