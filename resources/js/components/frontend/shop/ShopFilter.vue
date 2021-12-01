<template>
    <div class="filter row">
        <div class="filter-gtoup">
            <div>Поиск по названию</div>
            <input style="width: 90%" type="text" v-model="product_name" @keyup="doFilterProducts">
        </div>
        <div class="filter-group" v-for="group in attributes_groups" :key="group.group_id">
            <div>{{group.group_name}}</div>
            <attribute-button :selected_options="selected_options" :filtered_name="filtered_name" :attribute="attribute" @addFilterOption="addFilterOption" v-for="attribute in group.attributes" :key="attribute.id"></attribute-button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            attributes_groups: {},
            selected_options: {
                type: Array
            },
            filtered_name: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                product_name: '',
                filter_options: {}
            }
        },
        methods: {
            addFilterOption(option) {
                if(option.values.length) {
                    this.filter_options[option.attribute] = option.values;
                }
                else {
                    this.$delete(this.filter_options, option.attribute);
                }

                this.doFilterProducts();
            },
            doFilterProducts() {
                axios.post('/shop/filter', {
                    product_name: this.product_name,
                    filter: this.filter_options
                })
                .then(response => {
                    this.$emit('filterProducts', response.data)
                })
            }
        },
        created() {
            this.product_name = this.filtered_name;
        }
    }
</script>

<style lang="scss" scoped>
    .filter {
        color: #fff;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        flex: 0 0 20%;
        max-width: 20%;
    }
</style>
