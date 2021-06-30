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
            <select name="type" id="type" v-model="attribute.type" @change="changeAttributeType">
                <option value="0">...</option>
                <option v-for="(title, type) in attr_types" :value="type" :key="type">{{title}}</option>
            </select>
            <select v-show="iconsets.length" v-model="iconset_id" name="iconset" id="iconset" @change="getIconsForSet($event.target)">
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
                    :placeholder="'Введите значение и нажмите Enter'"
            />
        </div>
        <div class="form-group" v-show="attribute.type === 'range'">
            <div class="form-group row">
                <label for="range_min">Мин. значение</label>
                <input type="text" name="range_min" id="range_min" class="col-sm-2" v-model="range_min">
            </div>
            <div class="form-group row">
                <label for="range_max">Макс. значение</label>
                <input type="text" name="range_max" id="range_max" class="col-sm-2" v-model="range_max">
            </div>
            <div class="form-group row">
                <label for="range_step">Шаг слайдера</label>
                <input type="text" name="range_step" id="range_step" class="col-sm-2" v-model="range_step">
            </div>
        </div>
        <div class="form-group" v-if="attribute.type === 'color'">
            <div style="width: 30px;" v-for="(color,index) in tags" :key="index">
                <verte menuPosition="center" :value="tags[index]" :showHistory="false" :enableAlpha="false" model="hex" v-model="tags[index]"></verte>
            </div>
            <button type="button" class="btn btn-success clonspan" tabindex="-1" @click="addColor()"><i class="mdi mdi-plus"></i></button>
        </div>
        <div v-if="attribute.type === 'icon'">
            <div class="form-group row" v-for="(name, index) in tags" :key="index">
                <div class="form-group">
                    <input type="text" name="value_title" id="value_title" v-model="tags[index]" placeholder="Название">
                </div>
                <div class="form-group">
                    <v-select v-model="icons[index]" :options="options">
                        <template #selected-option="{ icon }">
                            <div style="display: flex; align-items: baseline;">
                                <img height="50px" :src="'/storage/images/' + icons[index].icon" />
                            </div>
                        </template>

                        <template slot="option" slot-scope="option">
                            <img height="50px" :src="'/storage/images/' + option.icon" />
                        </template>
                    </v-select>
                </div>
            </div>
            <button type="button" class="btn btn-success clonspan" tabindex="-1" @click="addIcon"><i class="mdi mdi-plus"></i></button>
        </div>

        <div class="form-group">
            <input type="submit" :value="submit_title">
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
                attribute: {},
                groups: [],
                attr_types: [],
                attr_colors: [],
                attributes_values: [],
                iconsets: [],
                iconset_id: 0,
                icons:[],
                selected_icons: [],
                selected_icon: '',
                tag: '',
                range_min:0,
                range_max:0,
                range_step:0,
                tags: [],
                errors: {},
                group_id: 0,
                mounted: false,
                options: [],
            }
        },
        methods: {
            setAttributeCategory(id) {
                this.attribute.category_id = id;
            },
            getAttributeValues() {
                console.log()
                axios.get('/api/getAttributeValues', {
                    params: {
                        attribute_id: this.attribute.id
                    }
                }).then(response => {
                    if(response.status == 200)
                    {
                        if(this.attribute.type === 'color') {
                            response.data.forEach(value => {
                                this.tags.push(value.value)
                            });
                        }
                        else if(this.attribute.type === 'icon') {
                            response.data.forEach(value => {
                                this.tags.push(value.value)
                            });
                        }
                        else if(this.attribute.type === 'range') {
                            this.range_min = response.data[0].value;
                            this.range_max = response.data[1].value;
                            this.range_step = response.data[2].value;
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

                    })
            },
            getIconsForSet(select) {
                const selected = select.options[select.options.selectedIndex].dataset;
                this.options = this.iconsets[selected.index].images;
            },
            getIcons() {
                axios.get('/api/getAttributeIcons', {
                    params: {
                        attribute_id: this.attribute.id
                    }
                })
                    .then((response) => {
                        this.options = response.data;
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
                while(this.tags.length > 0) {
                    this.tags.pop();
                }
            },
            addColor() {
                this.$set(this.tags, this.tags.length, '#498230');
            },
            addIcon() {
                this.$set(this.tags, this.tags.length, '');
            },
            setRangeValues() {
                this.$set(this.attributes_values, 0, this.range_min);
                this.$set(this.attributes_values, 1, this.range_max);
                this.$set(this.attributes_values, 2, this.range_step);
            },
            submit() {
                const formData = new FormData();

                Object.keys(this.attribute).forEach(key => {
                    formData.append(key, this.attribute[key])
                });

                if(this.attribute.type === 'text' || this.attribute.type === 'list')
                {
                    this.tags.forEach(tag => {
                        this.attributes_values.push(Object.values(tag)[0])
                    });
                }
                else if(this.attribute.type === 'range')
                {
                    this.setRangeValues();
                }

                else
                {
                    this.tags.forEach(tag => {
                        this.attributes_values.push(tag)
                    });
                }
                if(this.attribute.type === 'icon')
                {
                    let icons_ids = [];
                    this.icons.forEach(icon => {
                        icons_ids.push(icon.id);
                    })
                    formData.append('icons', icons_ids);
                    formData.append('iconset_id', this.iconset_id);
                }

                formData.append('values', this.attributes_values);

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
                            console.log(response.data)
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
                this.attribute = JSON.parse(this.attribute_data);

                if(this.attribute.type !== 'bool'){
                    this.getAttributeValues();
                }
                if(this.attribute.type === 'icon')
                {
                    this.getIconSets();
                    this.getIcons();
                }
            }
        },
    }
</script>
