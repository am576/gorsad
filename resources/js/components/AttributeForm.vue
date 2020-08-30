<template>
    <form @submit.prevent="submit">
        <div class="form-group">
            <label>Категория</label>
            <category-selector :children_only="true" :category="attribute.category_id"></category-selector>
            <div v-if="errors && errors.category_id" class="text-danger">{{errors.category_id[0]}}</div>
        </div>
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" id="name" name="name" v-model="attribute.name">
            <div v-if="errors && errors.name" class="text-danger">{{errors.name[0]}}</div>
        </div>
        <div class="form-group">
            <label>Значения</label>
            <vue-tags-input
                    v-model="tag"
                    :tags="tags"
                    @tags-changed="newTags => tags = newTags"
                    :placeholder="'Введите значение и нажмите Enter'"
            />
        </div>
        <div class="form-group">
            <input type="submit" :value="submit_title">
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            attribute_data: {},
            is_edit_form: false,
        },
        data() {
            return {
                attribute: {},
                tag: '',
                tags: [],
                errors: {}
            }
        },
        methods: {
            setAttributeCategory(id) {
                this.attribute.category_id = id;
                console.log(this.attribute);
            },
            getAttributeValues() {
                axios.get('/api/getAttributeValues', {
                    params: {
                        attribute_id: this.attribute.id
                    }
                }).then(response => {
                    if(response.status == 200)
                    {
                        response.data.forEach(value => {
                            this.tags.push({"text":value.value,"tiClasses":["ti-valid"]})
                        });
                    }
                })
            },
            submit() {
                const formData = new FormData();

                Object.keys(this.attribute).forEach(key => {
                    formData.append(key, this.attribute[key])
                });

                let values = [];
                this.tags.forEach(tag => {
                    values.push(Object.values(tag)[0])
                })

                formData.append('values', values);

                if(this.is_edit_form)
                {
                    formData.append('_method', 'PUT');

                    axios.post(`/admin/attributes/${this.attribute.id}`, formData)
                        .then(response =>{
                            if(response.status == 200)
                            {
                                window.location.href = '/admin/attributes'
                            }

                        }).catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        }
                    });
                }
                else
                {
                    axios.post(`/admin/attributes/`, formData)
                        .then(response =>{
                            if(response.status == 200)
                            {
                                window.location.href = '/admin/attributes'
                            }

                        }).catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        }
                    });
                }

            }
        },
        computed: {
            submit_title() {
                return this.is_edit_form ? 'Сохранить' : 'Создать'
            }
        },
        created() {
            this.$eventBus.$on('changeCategory', this.setAttributeCategory);
            if(this.is_edit_form)
            {
                this.attribute = this.attribute_data;
                this.getAttributeValues();
            }
        }
    }
</script>
