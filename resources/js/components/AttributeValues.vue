<template>
    <div>
        <div v-if="type === 'text'">
            <select name="attribute_value_id[]" v-model="value_id" @change="changeAttributeRange">
                <option value="0">...</option>
                <option v-for="value in values[index]" :value="value.id">{{value.value}}</option>
            </select>
        </div>
        <div v-if="type === 'color'">
            <span class="attribute-color" v-for="color in colors" v-bind:class="{selected: colors_ids.includes(color.id)}" v-bind:style="{background: color.value}" @click="changeSelectedColor(color.id)"></span>
        </div>
        <div v-if="type === 'range'">
            <vue-slider
                v-model="range_ids"
                :data="values"
                :data-value="'id'"
                :data-label="'value'"
                :tooltip="'always'"
                @change="changeAttributeValue()"
            ></vue-slider>
        </div>
        <div v-if="type === 'icon'">
            <v-select v-model="icons[index]" :options="options" @option:selected="changeAttributeIcon">
                <template #selected-option="{ icon }">
                    <div style="display: flex; align-items: baseline;">
                        <span>{{icons[index].label}}</span>
                        <img height="50px" :src="'/storage/images/' + icons[index].icon"/>
                    </div>
                </template>

                <template slot="option" slot-scope="option">
                    <span>{{option.label}}</span>
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
            index: 0
        },
        data() {
            return {
                value_id: 0,
                isSelected: false,
                range_ids: [],
                colors: [],
                colors_ids: [],
                icons: [],
                options: [],
                attr_id: 0
            }
        },
        methods: {
            changeAttributeValue() {
                this.$eventBus.$emit('changeAttributeValue', this.index, this.range_ids)
            },
            changeAttributeRange() {
                this.$eventBus.$emit('changeAttributeValue', this.index, this.range)
            },
            changeAttributeIcon() {
                console.log(this.icons[this.index])
                this.$eventBus.$emit('changeAttributeValue', this.index, [this.icons[this.index].value_id])
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
                                this.attr_id = values[0].id;
                            }
                        }
                        else if(values.length && this.type === 'color') {
                            if(this.colors.length === 0) {
                                this.colors = values;
                            }
                        }
                        /*else if(this.type === 'icon') {
                            this.options = values.options;
                            values.values.forEach((value, index) => {
                                this.$set(this.options[index], 'value_id', value.id);
                            })
                            this.attribute_id = values.values[0].id;
                        }*/
                    }
            },
            setAttributeValues(id, values) {
                if (id === this.attribute_id){
                    if(this.type === 'range') {
                        if (this.range_ids.length === 0) {
                            this.$set(this.range_ids, 0, Number(values[0].id));
                            this.$set(this.range_ids, 1, Number(values[1].id));
                        }
                    }
                    else if(this.type === 'color') {
                        this.colors = values.colors;
                        values.selected.forEach(color => {
                            this.colors_ids.push(color.id)
                        })
                    }
                    else if(this.type === 'icon') {
                        this.options = values.options;
                        this.icons[this.index] = values.values[0];
                        values.values[1].forEach((value, index) => {
                            this.$set(this.options[index], 'value_id', value.id);
                        })
                    }
                }
            },
            setRangeValues(va) {
                if (this.range_ids.length === 0) {
                    this.$set(this.range_ids, 0, va[0].id);
                    this.$set(this.range_ids, 1, va[1].id);
                }
            },
            setColorValues(values) {

            },
            initFields() {

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
        },
        created() {
            this.$eventBus.$on('getAttributeValues', this.getAttributeValues);
            this.$eventBus.$on('setAttributeValues', this.setAttributeValues);
        }

    }
</script>
