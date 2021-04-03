<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="filter-small col-md-10">
                <div class="filter-attributes">
                    <div class="filter-seg logo w-50">
                        Логотип
                    </div>
                    <div class="filter-seg">
                        <input class="form-control" v-model="product_name" placeholder="Искать по названию" type="text">
                    </div>
                    <div class="filter-seg" v-for="attribute in filter_attributes">
                        <button class="form-control" @click="setSelectedAttribute(attribute)">{{attribute.name}}</button>
                    </div>
                    <div class="filter-seg">
                        <form action="/search" method="post">
                            <input type="hidden" name="_token" :value="csrf">
                            <input name="product_name" type="hidden" v-model="product_name">
                            <textarea name="filter_options" type="hidden" class="hidden" style="display: none">{{selected_filter_options}}</textarea>
                            <button type="submit" class="btn btn-success w-100">Искать</button>
                        </form>

                    </div>
                </div>
                <div class="filter-attribute-values">
                    <div v-if="attribute.id === selected_attribute.id" class="attribute-values" v-for="attribute in filter_attributes">
                        <div class="attribute-value" v-for="value in attribute.values" v-bind:class="{selected: selected_filter_options[attribute.id].includes(value.id)}">
                            <div class="form-check">
                                <input v-if="attribute.type !== 'icon'" type="checkbox" class="form-check-input" style="width:25px; height:25px" :value="value.id" v-model="selected_filter_options[selected_attribute.id]">
                                <img v-if="attribute.type === 'icon'" :src="'/storage/images/' + value.icon" @click="setSelectedValue(attribute.id, value.id)">
                                <label class="form-check-label">{{value.value}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            filter_attributes: {}
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                selected_attribute: {},
                selected_filter_options: {},
                product_name: ''
            }
        },
        methods: {
            setSelectedAttribute(attribute) {
                this.selected_attribute = attribute.id === this.selected_attribute.id ? {} : attribute ;
            },
            setSelectedValue(attribute_id, value_id) {
                if (!(this.selected_filter_options[attribute_id].includes(value_id))) {
                    this.selected_filter_options[attribute_id].push(value_id)
                }
                else {
                    this.selected_filter_options[attribute_id].splice(this.selected_filter_options[attribute_id].indexOf(value_id, 1))
                }
            },
            applyFilter() {
                const formData = new FormData();

                formData.append('product_name', this.product_name);
                formData.append('filter_options', this.selected_filter_options);
                // this.$router.push({path: '/search', query:formData})
                // axios.post('/search', formData)

            }
        },
        created() {
            this.filter_attributes.forEach(attribute => {
                this.$set(this.selected_filter_options, attribute.id, [])
            })
        }
    }
</script>
<style lang="scss" scoped>
    .filter-small {
        .filter-attributes {
            display: flex;
            flex-direction: row;
            padding: 40px 20px 30px;
            background: #e1dad0;
        }
        .filter-attribute-values {
            background: #e1dad0;
            .attribute-values {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                .attribute-value {
                    margin: 5px;
                    width: 20%;
                    padding-bottom: 20px;
                    label {
                        margin-left: 20px;
                        word-break: break-all;
                    }
                }
                .attribute-value.selected {
                    border: 1px solid #ffffff;
                }
            }
        }
        .filter-seg {
            padding: 0 10px;
            width: 100%;

            input::placeholder {
                font-size: 12px;
            }
        }
        .filter-seg.logo {
            text-align: center;
            font-size: 24px;
        }

    }
</style>
