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
            <input type="text" id="name" name="name" v-model="attribute.name" autocomplete="off">
            <div v-if="errors && errors.name" class="text-danger">{{errors.name[0]}}</div>
        </div>
        <div class="form-group">
            <label>Тип</label>
            <select name="type" id="type" v-model="attribute.type" @change="changeAttributeType">
                <option value="0">...</option>
                <option v-for="(title, type) in attr_types" :value="type" :key="type">{{title}}</option>
            </select>
            <select v-show="attribute.type === 'icon' && iconsets.length" v-model="attribute.iconset_id" name="iconset" id="iconset" @change="getIconsForSet($event.target)">
                <option value="0">...</option>
                <option v-for="(iconset,index) in iconsets" :value="iconset.id" :key="index" :data-index="index">{{iconset.name}}</option>
            </select>
        </div>
        <div class="form-group" v-show="attribute.type === 'text' || attribute.type === 'list'">
            <label>Значения</label>
            <vue-tags-input
                    v-model="tag"
                    :tags="tags"
                    @tags-changed="newTags => tags = newTags"
                    @before-deleting-tag="removeTag"
                    @before-adding-tag="addTag"
                    :placeholder="'Введите значение и нажмите Enter'"
            />
        </div>
        <div class="form-group" v-show="attribute.type === 'range'">
            <div class="form-group row">
                <label for="range_min">Мин. значение</label>
                <input type="text" name="range_min" id="range_min" class="col-sm-2" v-model="range_min" maxlength="2">
            </div>
            <div class="form-group row">
                <label for="range_max">Макс. значение</label>
                <input type="text" name="range_max" id="range_max" class="col-sm-2" v-model="range_max" maxlength="3" max="100">
            </div>
            <div class="form-group row">
                <label for="range_step">Шаг слайдера</label>
                <input type="text" name="range_step" id="range_step" class="col-sm-2" v-model="range_step" maxlength="3">
            </div>
        </div>
        <div class="form-group" v-if="attribute.type === 'color'">
            <div class="d-flex align-items-center" style="width: 30%" v-for="(color,index) in attribute.values" :key="index">
                <verte menuPosition="center" :value="attribute.values[index].value" :showHistory="false" :enableAlpha="false" model="hex" v-model="attribute.values[index].value"></verte>
                <div class="d-block ml-3">
                    <input type="text" class="form-control" v-model="attribute.values[index].ext_value" placeholder="Название цвета" autocomplete="off" @focus="clearErrors('color_names')">
                    <small class="text-danger" v-show="hasErrors('color_names')">
                        {{errors.hasOwnProperty('color_names')?errors.color_names[index]:''}}
                    </small>
                </div>

                <span class="btn mdi mdi-minus mdi-24px" @click="removeColor(index)"></span>
            </div>
            <button type="button" class="btn btn-success clonspan" tabindex="-1" @click="addColor()"><i class="mdi mdi-plus"></i></button>
        </div>
        <div v-if="attribute.type === 'icon'">
            <div class="form-group row align-items-center" v-for="(value, index) in attribute.values" :key="index">
                <div class="form-group m-0">
                    <input type="text" name="value_title" id="value_title" v-model="value.value" placeholder="Название" required>
                </div>
                <div class="form-group m-0">
                    <v-select v-model="value.image" :options="options">
                        <template #selected-option="{ icon }">
                            <div style="display: flex; align-items: baseline;">
                                <img height="50px" :src="'/storage/images/' + value.image.icon" />
                            </div>
                        </template>

                        <template slot="option" slot-scope="option">
                            <img height="50px" :src="'/storage/images/' + option.icon" />
                        </template>
                    </v-select>
                </div>
                <span class="btn mdi mdi-minus mdi-24px" @click="removeIcon(index)"></span>
            </div>
            <button type="button" class="btn btn-success clonspan" tabindex="-1" @click="addIcon"><i class="mdi mdi-plus"></i></button>
        </div>

        <div class="form-group">
            <input v-if="is_edit_form && attribute.type!=='range'" type="submit" :value="submit_title">
        </div>
    </form>
</template>

<script>
    import Verte from 'verte';
    import 'verte/dist/verte.css';
    import vSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css';

    export default {
        components: {
            Verte,
            vSelect
        },
        props: {
            attribute_data: {},
            is_edit_form: false,
        },
        data() {
            return {
                attribute: {values:[]},
                groups: [],
                attr_types: [],
                attributes_values: [],
                iconsets: [],
                icons:[],
                tag: '',
                tags: [],
                errors: {},
                group_id: 0,
                options: [],
                values_to_delete: [],
                range_min:0,
                range_max:1,
                range_step:1,
            }
        },
        methods: {
            setAttributeCategory(id) {
                this.attribute.category_id = id;
            },
            getAttributeValues() {
                axios.get('/api/getAttributeValues', {
                    params: {
                        attribute_id: this.attribute.id
                    }
                }).then(response => {
                    if(response.status == 200)
                    {
                        if(this.attribute.type === 'icon') {
                            response.data.forEach(value => {
                                this.tags.push(value.value)
                            });
                        }
                        else {
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
            getIconSets() {
                axios.get('/api/getIconsets')
                    .then((response) => {
                        this.iconsets = response.data;
                        this.getIconsForSet();
                    })
            },
            getIconsForSet() {
                this.iconsets.forEach(iconset => {
                    if(iconset.id === this.attribute.iconset_id)
                    {
                        this.options = iconset.images;
                    }
                })
            },
            getIcons() {
                axios.get('/api/getAttributeIcons', {
                    params: {
                        attribute_id: this.attribute.id
                    }
                })
                    .then((response) => {
                        this.icons = response.data;
                    })
            },
            changeAttributeType() {
                this.clearValues();
                if(this.attribute.type === 'icon' && !this.iconsets.length)
                {
                    this.getIconSets();
                }
            },
            clearValues() {
                this.attribute.values = [];
                while(this.tags.length > 0) {
                    this.tags.pop();
                }
            },
            addTag(obj) {
                this.attribute.values.push(
                    {
                        attribute_id: this.attribute.id,
                        value: obj.tag.text,
                    }
                )
                obj.addTag();
            },
            removeTag(obj) {
                this.addValueToDelete(this.attribute.values[obj.index]);
                this.$delete(this.attribute.values, obj.index);
                obj.deleteTag();
            },
            addColor() {
                this.attribute.values.push(
                    {
                        attribute_id: this.attribute.id,
                        value: '#498230',
                        ext_value: '',
                    }
                )
            },
            removeColor(index) {
                this.addValueToDelete(this.attribute.values[index]);
                this.$delete(this.attribute.values, index);
            },
            addIcon() {
                this.attribute.values.push(
                    {
                        value: '',
                        ext_value: '',
                    }
                )
            },
            removeIcon(index) {
                this.addValueToDelete(this.attribute.values[index]);
                this.$delete(this.attribute.values, index);
            },
            addValueToDelete(value) {
                this.values_to_delete.push(value)
            },
            setRangeValues() {
                this.clearValues();
                this.attribute.values.push(
                    {value: this.range_min},
                    {value: this.range_max},
                    {value: this.range_step},
                )
            },
            submit() {
                if(this.validate()) {
                    const formData = new FormData();

                    Object.keys(this.attribute).forEach(key => {
                        formData.append(key, this.attribute[key])
                    });
                    if (this.attribute.type === 'range') {
                        this.setRangeValues();
                    }
                    if (this.attribute.type === 'icon') {
                        formData.append('iconset_id', this.attribute.iconset_id);
                    }
                    formData.append('values', JSON.stringify(this.attribute.values));
                    formData.append('delete_values', JSON.stringify(this.values_to_delete));

                    if (this.is_edit_form) {
                        formData.append('_method', 'PUT');

                        axios.post(`/admin/attributes/${this.attribute.id}`, formData)
                            .then(response => {
                                if (response.status == 200) {
                                    window.location.href = '/admin/attributes'
                                }
                            }).catch(error => {
                            if (error.response.status === 422) {
                                this.errors = error.response.data || {};
                                alert(error.response.data);
                            }
                        });
                    }
                    else {
                        axios.post(`/admin/attributes/`, formData)
                            .then(response => {
                                if (response.status == 200) {
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
            validate() {
                let validated = true;
                if(this.attribute.type === 'color') {
                    this.$set(this.errors,'color_names', []);
                    this.attribute.values.forEach((v, i) => {
                        if(!v.ext_value) {
                            this.$set(this.errors.color_names, i , 'Укажите название цвета');
                            validated = false;
                        }
                    })
                }

                return validated;
            },
            hasErrors(error_name) {
                if (this.errors.hasOwnProperty(error_name))
                {
                    return this.errors[error_name].length > 0
                }
                return false;
            },
            clearErrors(error_name) {
                this.$set(this.errors,error_name, []);
            }
        },

        computed: {
            submit_title() {
                return this.is_edit_form ? 'Сохранить' : 'Создать'
            },
            isTagsEmpty() {
                return this.tags.length === 0
            },

        },
        created() {
            this.getAttributesGroups();
            this.getAttributesTypes();
            this.$eventBus.$on('changeCategory', this.setAttributeCategory);

            if(this.is_edit_form)
            {
                this.attribute = JSON.parse(this.attribute_data);

                if(this.attribute.type !== 'bool'){
                    this.getAttributeValues();
                }
                if(this.attribute.type === 'icon')
                {
                    this.getIconSets();
                    this.getIcons();
                }
                if(this.attribute.type === 'range') {
                    this.range_min = this.attribute.values[0].value;
                    this.range_max = this.attribute.values[1].value;
                    this.range_step = this.attribute.values[2].value;
                }
            }
        },
    }
</script>
