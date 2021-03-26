<template>
    <div>
        <div v-if="type === 'text'">
            <select name="attribute_value_id[]" v-model="value_id" @change="changeAttributeValue">
                <option value="0">...</option>
                <option v-for="value in values[index]" :value="value.id">{{value.value}}</option>
            </select>
        </div>
        <div v-if="type === 'color'">
            <span class="attribute-color" v-for="value in values[index]" v-bind:class="{selected: value.id === value_id}" v-bind:style="{background: value.value}" @click="changeSelectedColor(value.id)"></span>
        </div>
        <div v-if="type === 'range'">
            <vue-slider
                v-model="value_id"
                :interval="Number(values[index][2].value)"
                :data="values[index]"
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
                default:  []
            },
            index: 0
        },
        data() {
            return {
                value_id: 1,
                isSelected: false,
            }
        },
        methods: {
            changeAttributeValue() {
                this.$eventBus.$emit('changeAttributeValue', this.index, this.value_id)
            },
            changeSelectedColor(id) {
                this.value_id = id;
                this.$eventBus.$emit('changeAttributeValue', this.index, this.value_id)
            }
        }
    }
</script>
