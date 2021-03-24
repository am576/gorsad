<template>
    <div>
        <div v-if="type === 'text'">
            <select name="attribute_value_id[]" v-model="value" @change="changeAttributeValue">
                <option value="0">...</option>
                <option v-for="value in values[index]" :value="value.id">{{value.value}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            type: '',
            values: {
                type: Array,
                default: () => []
            },
            index: 0
        },
        data() {
            return {
                value: ''
            }
        },
        methods: {
            changeAttributeValue() {
                this.$eventBus.$emit('changeAttributeValue', this.index, this.value)
            }
        }
    }
</script>
