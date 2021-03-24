<template>
    <form @submit.prevent="submit">
        <div class="form-group">
            <label>Категория</label>
            <category-selector :children_only="true" :category="attribute.category_id"></category-selector>
            <div v-if="errors && errors.category_id" class="text-danger">{{errors.category_id[0]}}</div>
        </div>
        <div class="form-group">
            <label>Группа</label>
            <select name="group_id" id="group_id" v-model="attribute.group_id">
                <option value="0">...</option>
                <option v-for="group in groups" :value="group.id" :key="group.id">{{group.title}}</option>
            </select>
            <div v-if="errors && errors.category_id" class="text-danger">{{errors.group_id[0]}}</div>
        </div>
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" id="name" name="name" v-model="attribute.name">
            <div v-if="errors && errors.name" class="text-danger">{{errors.name[0]}}</div>
        </div>
        <div class="form-group">

            <label>Тип</label>
            <select name="type" id="type" v-model="attribute.type" @change="clearValues">
                <option value="0">...</option>
                <option v-for="(title, type) in attr_types" :value="type" :key="type">{{title}}</option>
            </select>
        </div>
        <div class="form-group" v-show="attribute.type === 'text' || attribute.type === 'list'">
            <label>Значения</label>
            <vue-tags-input
                    v-model="tag"
                    :tags="tags"
                    @tags-changed="newTags => tags = newTags"
                    :placeholder="'Введите значение и нажмите Enter'"
            />
        </div>
        <div class="form-group" v-show="attribute.type === 'range'">
            <div class="form-group row">
                <label for="range_min">Мин. значение</label>
                <input type="text" name="range_min" id="range_min" class="col-sm-2" v-model="tags[0]">
            </div>
            <div class="form-group row">
                <label for="range_max">Макс. значение</label>
                <input type="text" name="range_max" id="range_max" class="col-sm-2" v-model="tags[1]">
            </div>
            <div class="form-group row">
                <label for="range_step">Шаг слайдера</label>
                <input type="text" name="range_step" id="range_step" class="col-sm-2" v-model="tags[2]">
            </div>
        </div>
        <div class="form-group" v-if="attribute.type === 'color'">
            <div style="width: 30px;" v-for="(color,index) in tags" :key="index">
                <verte menuPosition="center" :value="tags[index]" :showHistory="false" :enableAlpha="false" model="hex" v-model="tags[index]"></verte>
            </div>
            <button type="button" class="btn btn-success clonspan" tabindex="-1" @click="addColor()"><i class="mdi mdi-plus"></i></button>
        </div>
        <div class="form-group">
            <input type="submit" :value="submit_title">
        </div>
    </form>
</template>

<script>
    import Verte from 'verte';
    import 'verte/dist/verte.css';

    export default {
        components: { Verte },
        props: {
            attribute_data: {},
            is_edit_form: false,
        },
        data() {
            return {
                attribute: {},
                groups: [],
                attr_types: [],
                attr_colors: [],
                tag: '',
                tags: [],
                errors: {},
                group_id: 0,
                mounted: false,
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
                        if(this.attribute.type === 'range' || 'color')
                        {
                            response.data.forEach(value => {
                                this.tags.push(value.value)
                            });
                        }
                        else
                        {
                            response.data.forEach(value => {
                                this.tags.push({"text":value.value,"tiClasses":["ti-valid"]})
                            });
                        }
                    }
                })
            },
            getAttributesGroups() {
                axios.get('/api/getAttributesGroups')
                    .then((response) => {
                        this.groups = response.data;
                    })
            },
            getAttributesTypes() {
                axios.get('/api/getAttributesTypes')
                    .then((response) => {
                        this.attr_types = response.data;
                    })
            },
            clearValues() {
                while(this.tags.length > 0) {
                    this.tags.pop();
                }
            },
            addColor() {
                this.$set(this.tags, this.tags.length, '#ffccbb');
            },
            submit() {
                const formData = new FormData();

                Object.keys(this.attribute).forEach(key => {
                    formData.append(key, this.attribute[key])
                });

                let values = [];
                this.tags.forEach(tag => {
                    if(this.attribute.type === 'text' || this.attribute.type === 'list')
                    {
                        values.push(Object.values(tag)[0])
                    }
                    else
                        values.push(tag)
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

            this.getAttributesGroups();
            this.getAttributesTypes();
            this.$eventBus.$on('changeCategory', this.setAttributeCategory);
            if(this.is_edit_form)
            {
                this.attribute = this.attribute_data;

                if(this.attribute.type !== 'bool'){
                    this.getAttributeValues();
                }
            }
        },
    }
</script>
