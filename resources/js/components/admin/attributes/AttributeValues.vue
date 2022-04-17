<template>
    <div>
        <div v-if="type === 'text'">
            <v-select multiple v-model="selected" :reduce="value => value.id" label="value" :options="values" @option:selected="changeAttributeValue" @option:deselected="changeAttributeValue"/>
        </div>
        <div v-if="type === 'color'">
            <span class="attribute-color"  v-for="(color) in values" v-bind:class="{selected: selected.includes(color.id)}" v-bind:style="{background: color.value}" @click="changeSelectedColor(color.id)"></span>
        </div>
        <div v-if="type === 'range'">
            <vue-slider
                v-model="values.range"
                :data="values"
                :data-value="'id'"
                :data-label="'value'"
                :tooltip="'always'"
                :tooltip-placement="'bottom'"
                @change="changeAttributeRange()"
            ></vue-slider>
        </div>
        <div v-if="type === 'icon'">
            <v-select multiple v-model="icons_selected" :options="icons" @option:selected="changeAttributeIcon" @option:deselected="changeAttributeIcon" :dropdown-should-open="dropdownShouldOpen">
                <template #selected-option="{ icon_name, icon }">
                    <div style="display: flex; align-items: baseline; color: black">
                        <span>{{icon_name}}</span>
                        <img height="50px" :src="'/storage/images/' + icon"/>
                    </div>
                </template>

                <template slot="option" slot-scope="option">
                    <span>{{option.icon_name}}</span>
                    <img height="50px" :src="'/storage/images/' + option.icon"/>
                </template>
            </v-select>
        </div>

    </div>
</template>

<script>
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/default.css'
    import vSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css';
    export default {
        components: {
            VueSlider,
            vSelect
        },
        props: {
            attribute_id: 0,
            type: '',
            values: {
                type: Array,
                default:  function() {return []}
            },
            selected: {
                type: Array,
                default:  function() {return []}
            },
            index: 0
        },
        data() {
            return {
                value_id: 0,
                range_ids: [],
                colors: [],
                colors_ids: [],
                icons: [],
                options: [],
                text_options: [],
                attr_id: 0,
                selected_id:0,
                selected_text_options: [],
                icons_selected: [],
                i: 0
            }
        },
        methods: {
            dropdownShouldOpen() {
                return true;
            },
            changeAttributeRange() {
                this.$eventBus.$emit('changeAttributeValue', this.index, this.values.range)
            },
            changeAttributeValue() {
                this.$eventBus.$emit('changeAttributeValue', this.index, this.selected)
            },
            changeAttributeIcon(v) {
                this.selected[0] = v.value_id;
                this.$eventBus.$emit('changeAttributeValue', this.index, this.icons_selected)
            },
            changeSelectedColor(id) {
                this.value_id = id;
                if(!this.colors_ids.includes(id)) {
                    this.colors_ids.push(id)
                }
                else {
                    this.colors_ids.splice(this.colors_ids.indexOf(id), 1);
                }
                this.$eventBus.$emit('changeAttributeValue', this.index, this.colors_ids)
            },
            getAttributeValues(values) {

                    if(values.length || Object.keys(values).length) {
                        if (values.length && this.type === 'range') {
                            if (this.range_ids.length === 0) {
                                this.setRangeValues(values)
                            }
                        }
                        else if(values.length && this.type === 'color') {
                            if(this.colors.length === 0) {
                                this.attr_id = values[0].attribute_id;
                                this.colors_ids = selected;
                                this.colors = values;
                            }
                        }
                        else if(this.type === 'icon') {
                            this.options = values.options;

                            values.values.forEach((value, index) => {
                                this.$set(this.options[index], 'value_id', value.id);
                                this.$set(this.values.icons[index], 'value_id', value.id);
                            })
                        }
                        else {
                            if(this.text_options.length === 0) {
                                this.attr_id = values[0].attribute_id;
                                this.text_options = values;
                                this.selected_text_options = this.selected;
                            }
                        }
                    }
            },
            setAttributeValues(id, values) {
                if (id === this.attribute_id) {
                    if(this.type === 'range') {
                        if (this.range_ids.length === 0) {
                            this.values = values;
                        }
                    }
                    else if(this.type === 'color') {
                        this.values = values;
                        this.colors_ids = this.selected;
                    }
                    else if(this.type === 'icon') {
                        this.icons = values.icons;

                        this.values.forEach((value,index) => {
                            this.$set(this.icons[index], 'icon_name', value.value)
                        })
                        this.selected.forEach(selected_id => {
                            this.icons.forEach(icon => {
                                if(selected_id === icon.value_id) {
                                    this.icons_selected.push(icon);
                                }
                            })

                        })
                    }
                    else if(this.type === 'text') {
                        this.values = values;
                       this.text_options = values;
                    }
                }
            },
            setRangeValues(va) {
                if (this.range_ids.length === 0) {
                    this.$set(this.range_ids, 0, va[0]);
                    this.$set(this.range_ids, 1, va[1]);
                }
            },
            setAttributeOptions(index, icons) {
                if(this.index === index) {
                    this.icons = icons;
                }
            }
        },
        computed: {
            range_values: {
                cache: false,
                get: function() {
                    if (this.type === 'range' ) {
                        return [this.range[0], this.range[1]];
                    }
                },
                set: function(newValue) {
                    this.$set(this.range, 0, newValue[0]);
                    this.$set(this.range, 1, newValue[1]);
                }
            },
            selectedIcon() {
                let icon =''
                this.values.forEach(value => {
                    if(this.selected[0] === value.id) {
                        icon = value.image.icon;
                    }
                })
                return icon;
            },
            selectedLabel() {
                let label = '';
                this.values.forEach(value => {
                    if(this.selected[0] === value.id) {
                        label = value.value
                    }
                })
                return label;
            }
        },
        created() {
            this.$eventBus.$on('getAttributeValues', this.getAttributeValues);
            this.$eventBus.$on('setAttributeValues', this.setAttributeValues);
            this.$eventBus.$on('setAttributeOptions', this.setAttributeOptions);
            // this.$eventBus.$on('addOptions', this.addOptions);
            // this.$eventBus.$on('setTextValues', this.setTextValues);
        }

    }
</script>
