<template>
    <div class="filter row">
        <div class="filter-gtoup">
            <input type="text" v-model="product_name" @keyup="doFilterProducts">
        </div>
        <div class="filter-group" v-for="group in attributes_groups" :key="group.group_id">
            <div>{{group.group_name}}</div>
            <div v-for="attribute in group.attributes">
                <attribute-button :attribute="attribute" @addFilterOption="addFilterOption"></attribute-button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            attributes_groups: {}
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
