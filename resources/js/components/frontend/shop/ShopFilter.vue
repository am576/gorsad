<template>
    <div class="filter row">
        <div class="filter-group">
            <div class="filter-group-title">Поиск по названию</div>
            <input id="name-search" type="text" v-model="product_name" @keyup="doFilterProducts">
        </div>
        <div class="filter-group" v-for="group in attributes_groups" :key="group.group_id">
            <div class="filter-group-title">{{group.group_name}}</div>
            <attribute-button :selected_options="selected_options[attribute.id]" :filtered_name="filtered_name" :attribute="attribute" @addFilterOption="addFilterOption" v-for="attribute in group.attributes" :key="attribute.id"></attribute-button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            attributes_groups: {},
            selected_options: {
                type: Object
            },
            filtered_name: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                product_name: '',
                filter_options: {},
                isMobileView: false,
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
                    this.$emit('filterProducts', response.data, this.filter_options)
                })
            },
            handleView() {
                this.isMobileView = window.innerWidth <= 600;
            },
        },
        created() {
            this.product_name = this.filtered_name;
            this.handleView();
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
        @media (min-width: 591px) {
            flex: 0 0 20%;
            max-width: 20%;
        }
        @media (max-width: 590px) {
            flex: 0 0 100%;
            max-width: 100%;
            align-items: center;
            .filter-group-title {
                text-align: center;
                margin: 2.5vh 0 1.25vh;
                background-color: #514a4a;
                padding: 0.5vh 0;
                width: 100%;
            }
        }
        #name-search {
            @media (min-width: 591px) {
                width: 90%;
            }
            @media (max-width: 590px) {
                width: 70%;
            }
        }
    }
</style>
