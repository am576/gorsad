<template>
    <div>
        <div v-if="type === 'text'">
            <select name="attribute_value_id[]" v-model="value_id" @change="changeAttributeRange">
                <option value="0">...</option>
                <option v-for="value in values[index]" :value="value.id">{{value.value}}</option>
            </select>
        </div>
        <div v-if="type === 'color'">
            <span class="attribute-color" v-for="value in values[index]" v-bind:class="{selected: value.id === value_id}" v-bind:style="{background: value.value}" @click="changeSelectedColor(value.id)"></span>
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

    </div>
</template>

<script>
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/default.css'
    export default {
        components: {
            VueSlider
        },
        props: {
            type: '',
            values: {
                type: Array,
                default:  function() {return []}
            },
            index: 0
        },
        data() {
            return {
                value_id: 1,
                isSelected: false,
                range_ids: []
            }
        },
        methods: {
            changeAttributeValue() {
                this.$eventBus.$emit('changeAttributeValue', this.index, this.range_ids)
            },
            changeAttributeRange() {
                this.$eventBus.$emit('changeAttributeValue', this.index, this.range)
            },
            changeSelectedColor(id) {
                this.value_id = id;
                this.$eventBus.$emit('changeAttributeValue', this.index, this.range_ids)
            },
            setRangeValues(va) {
                if (this.type === 'range' && this.range_ids.length === 0) {
                    this.$set(this.range_ids, 0, va[0].id);
                    this.$set(this.range_ids, 1, va[1].id);
                }
            },
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
            }
        },
        created() {
            this.$eventBus.$on('getAttributeValues', this.setRangeValues)
        }

    }
</script>
