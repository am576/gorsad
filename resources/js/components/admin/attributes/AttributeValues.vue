<template>
    <div>
        <div v-if="type === 'text'">
            <v-select multiple v-model="selected_values"  label="value" :options="values" @option:selected="changeAttributeValue" @option:deselected="changeAttributeValue"/>
        </div>
        <div v-if="type === 'color'">
            <v-select multiple v-model="selected_values" :options="values"  @option:selected="changeAttributeValue" @option:deselected="changeAttributeValue">
                <template #selected-option="{value, ext_value}">
                    <div style="display: flex; align-items: center; color: black">
                        <span>{{ext_value}}</span>
                        <span class="attribute-color" v-bind:style="{background: value}"></span>
                    </div>
                </template>

                <template slot="option" slot-scope="option">
                    <span>{{option.ext_value}}</span>
                    <span class="attribute-color" v-bind:style="{background: option.value}"></span>
                </template>
            </v-select>
        </div>
        <div v-if="type === 'range'">
            <vue-slider
                v-model="range_values"
                :tooltip="'always'"
                :tooltip-placement="'bottom'"
                :enable-cross="false"
                :data-value="'id'"
                :data-label="'value'"
                :min="range_min"
                :max="range_max"
                :lazy="true"
                @change="changeAttributeRange"
            ></vue-slider>
        </div>
        <div v-if="type === 'icon'">
            <v-select multiple v-model="selected_values" :options="values"  @option:selected="changeAttributeValue" @option:deselected="changeAttributeValue">
                <template #selected-option="{value, icon}">
                    <div style="display: flex; align-items: center; color: black">
                        <span>{{value}}</span>
                        <img height="40px" :src="'/storage/images/' + icon.image.icon"/>
                    </div>
                </template>

                <template slot="option" slot-scope="option">
                    <span>{{option.value}}</span>
                    <img height="40px" :src="'/storage/images/' + option.icon.image.icon"/>
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
            selected_values: [],
            index: 0
        },
        data() {
            return {

                range: [],
                range_min: 0,
                range_max: 50
            }
        },
        methods: {
            changeAttributeRange(va) {
                this.$eventBus.$emit('changeAttributeValue', this.index, this.range)
            },
            changeAttributeValue() {
                this.$eventBus.$emit('changeAttributeValue', this.index, this.selected_values)
            },
            setRangeValues() {
                if(this.selected_values.length) {
                    this.range[0] = this.selected_values[0].value
                    this.range[1] = this.selected_values[1].value
                }
                else {
                    this.range[0] = this.range_min;
                    this.range[1] = this.range_max;
                }
            }
        },
        computed: {
            range_values: {
                cache: false,
                get: function() {
                    if (this.type === 'range' ) {
                        if(this.selected_values.length) {
                            return [this.range[0], this.range[1] = this.range[1]]
                        }
                        else {
                            return [this.range_min, this.range_max]
                        }
                    }
                },
                set: function(newValue) {
                    this.$set(this.range, 0, newValue[0]);
                    this.$set(this.range, 1, newValue[1]);
                }
            },
        },
        created() {
            // this.selected_values = this.selected;
            if(this.type === 'range') {
                this.setRangeValues();
            }
        },
        mounted() {
            if(this.type === 'range') {
                this.setRangeValues();
            }
        }
    }
</script>
