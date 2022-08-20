<template>
    <div class="attribute-button">
        <div class="attribute-caption row" :class="{selected:isSelected}" @click="selectAttribute()">
            <span class="mdi mdi-24px d-flex" :class="arrow"></span>
            <div class="d-flex">
                {{attribute.name}}
            </div>
            <span class="mdi mdi-18px mdi-close ml-auto" v-show="hasSelectedOptions" @click.prevent.stop="clearSelectedValues()"></span>
        </div>
        <div class="attribute-values" v-show="selected">
            <div v-if="attribute.type === 'text'">
                <div class="mb-3 bv-no-focus-ring">
                    <div class="custom-control custom-checkbox" v-for="attr_value in attribute.values">
                        <input type="checkbox" class="custom-control-input" v-model="selected_values"
                               :value="attr_value.id" @change="addFilterOption" style="z-index: 100;">
                        <label class="custom-control-label" @click="addFilterOption">{{attr_value.value}}</label>
                    </div>
                </div>
            </div>
            <div v-else-if="attribute.type === 'range'">
                <vue-slider
                    v-model="range"
                    :data="attribute.values"
                    :data-value="'id'"
                    :data-label="'value'"
                    :tooltip="'always'"
                    :tooltip-placement="'bottom'"
                    :enable-cross="false"
                    :marks="false"
                    :hide-label="true"
                    @change="applyRangeFilter"
                ></vue-slider>
            </div>
            <div class="values-container" v-else-if="attribute.type === 'color'">
                <span class="color-option"  v-for="color in attribute.values" :class="{selected: selected_values.includes(color.id)}" :style="{background: color.value}" @click="selectValue(color.id)"></span>
            </div>
            <div class="values-container " v-else-if="attribute.type === 'icon'" >
                <div class="icon-option" :class="[attribute.values.length <= 3 ? 'fw' : 'sw', selected_values.includes(value.id) ? 'selected' : '']"
                     v-for="value in attribute.values" @click="selectValue(value.id)"
                >
                    <div>
                        <img height="50px" :src="'/storage/images/' + value.icon"/>
                    </div>
                    <div class="ml-3 word-break">{{value.value}}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/default.css'
    export default {
        components: {
            VueSlider,
        },
        props: {
            attribute: {
                type: Object
            },
            selected_options: {
                type: Array
            }
        },
        data() {
            return {
                selected: false,
                selected_values: [],
                range: [],
                checked: []
            }
        },
        methods: {
            selectAttribute() {
                this.selected = !this.selected;
            },
            clearSelectedValues() {
                this.selected_values.splice(0);
                this.selected = false;
                this.setDefaultValues();
                this.addFilterOption();
            },
            setDefaultValues() {
                if(this.attribute.type === 'range') {
                    this.$set(this.range, 0, this.attribute.values[0].id)
                    this.$set(this.range, 1, this.attribute.values[this.attribute.values.length-1].id)
                }
            },
            selectValue(id) {
                if(!this.selected_values.includes(id)) {
                    this.selected_values.push(id)
                }
                else {
                    this.selected_values.splice(this.selected_values.indexOf(id), 1);
                }
                this.addFilterOption();
            },
            applyRangeFilter() {
                this.selected_values.splice(0);
                for (let i = this.range[0]; i <= this.range[1]; i++) {
                    this.selected_values.push(i);
                }
                this.addFilterOption();
            },
            addFilterOption(e) {
                let option = {};
                option['attribute'] = this.attribute.id;
                option['values'] = this.selected_values;
                this.$emit('addFilterOption', option);
            },
            setSelectedValues() {
                if(this.selected_options) {
                    this.selected_values = this.selected_options;
                }
            }
        },
        computed: {
            arrow() {
                return this.selected ? 'mdi-chevron-down' : 'mdi-chevron-right';
            },
            isSelected() {
                return (this.selected || this.selected_values.length > 0)
            },
            hasSelectedOptions() {
                return this.selected_values.length > 0
            },
            allowMaxWidthDropdowm() {
                return this.attribute.type === 'icon' && this.attribute.values.length > 3
            }
        },
        created() {
            this.setDefaultValues();
            this.setSelectedValues();
        }
    }
</script>

<style lang="scss" scoped>
    .attribute-button {
        width: 100%;
    }
    .attribute-caption {
        margin-left: 0;
        margin-right: 0;
        align-items: center;
        background: #2f2f2f;
        border: 1px solid #191919;
        cursor: pointer;

        &:hover, &.selected {
            background: #3e3b3b;
        }
    }

    .attribute-values {
        display: flex;
        flex-direction: column;
        position: absolute;
        background: #3e3b3b;
        z-index: 1;
        @media (min-width: 1000px) {
            width: 20% !important;
        }
        @media (max-width: 1000px) {
            width: 100% !important;
            padding-left: 4vw;
            padding-top: 4vw;
        }
    }

    .vue-slider-marks {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
    }

    .values-container {
        display: flex;
        flex-wrap: wrap;
        padding: 10px 20px;
    }

    .color-option {
        cursor: pointer;
        display: block;
        height: 30px;
        width: 30px;
        border-radius: 20px;
        margin-right: 10px;
        margin-bottom: 10px;

        &.selected {
            border: 2px solid #7cfc00;
        }
    }

    .icon-option {
        display: flex;
        align-items: center;
        margin-top: 15px;
        cursor: pointer;
        border: 1px solid transparent;

        &.fw {
            flex: 0 0 100%;
        }

        &.sw {
            flex: 0 0 33.3333%
        }

        &:hover {
            border: 1px solid #fff;
        }

        &.selected {
            border: 1px solid #7cfc00;
        }
    }

    .word-break {
        word-break: break-word;
    }

    .w-20 {
        width: 20% !important;
    }

</style>
