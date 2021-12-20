<template>
    <div id="filter" class="pl-4 pr-4" :class="{container: !isMobileView}">
            <div class="filter-small col-md-12">
                <div class="filter-attributes">
                    <div class="filter-seg">
                        <input class="form-control" v-model="product_name" placeholder="Искать по названию" type="text" @keyup.enter="submit">
                    </div>
                    <div class="filter-seg" v-for="attribute in filter_attributes">
                        <button class="btn filter-btn" @click="setSelectedAttribute(attribute)">{{attribute.name}}
                            <i class="mdi mdi-chevron-down-circle-outline mdi-24px" v-if="isMobileView"></i>
                        </button>

                    </div>
                    <div class="filter-seg">
                        <form action="/search" method="post">
                            <input type="hidden" name="_token" :value="csrf">
                            <input name="product_name" type="hidden" v-model="product_name">
                            <textarea name="filter_options" type="hidden" class="hidden" style="display: none">{{selected_filter_options}}</textarea>
                            <button ref="submitButton" type="submit" class="btn search-btn w-100" >Искать</button>
                        </form>
                    </div>
                </div>
                <div class="filter-attribute-values">
                    <div v-if="attribute.id === selected_attribute.id" class="attribute-values" v-for="attribute in filter_attributes">
                        <div class="attribute-value" v-for="value in attribute.values" v-bind:class="{selected: selected_filter_options[attribute.id].includes(value.id)}">
                            <div class="form-check" @click="setSelectedValue(attribute.id, value.id)">
                                <span v-if="attribute.type === 'color'" class="attribute-color"  v-bind:style="{background: value.value}" ></span>
                                <input  v-if="attribute.type === 'text'" type="checkbox" class="form-check-input" style="width:25px; height:25px" :value="value.id" v-model="selected_filter_options[selected_attribute.id]">
                                <img v-if="attribute.type === 'icon'" :src="'/storage/images/' + value.icon">
                                <label v-if="attribute.type !== 'color'" class="form-check-label">{{value.value}}</label>
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
                product_name: '',
                isMobileView : false,
            }
        },
        methods: {
            handleView() {
                this.isMobileView = window.innerWidth <= 600;
            },
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

            },
            submit() {
                this.$refs.submitButton.click();
            }
        },
        created() {
            this.filter_attributes.forEach(attribute => {
                this.$set(this.selected_filter_options, attribute.id, [])
            })
            this.handleView();
        }
    }
</script>
<style lang="scss" scoped>
    #filter {
        @media (max-width: 590px) {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }
    }
    .filter-small-wrapper {
        justify-content: center;
    }
    .filter-small {
        @media (max-width: 590px) {
            padding: 0 !important;
        }
        .filter-attributes {
            display: flex;
            @media (min-width: 591px) {
                flex-direction: row;
                padding: 60px 20px 50px;
                background: rgba(0, 0, 0, 0.7);
            }
            @media (max-width: 590px) {
                flex-direction: column;
                padding: 2vh 6vh;
                background-color: #e0d9cf;
                input.form-control {
                    padding: 15px;
                    font-size: 18px;
                    margin-bottom: 2vh;
                    &::placeholder {
                        font-size: 18px;
                    }
                }
            }
            flex-direction: row;
            padding: 60px 20px 50px;
            background: rgba(0, 0, 0, 0.7);

            .btn {
                @media (min-width: 591px) {
                    color: #ffffff;
                    border: none;
                    border-radius: 5px;
                    width: 100%;
                    padding: 12px 0;
                    font-size: 18px;

                    &.filter-btn {
                        background: #707072;
                        font-weight: bold;
                    }
                    &.search-btn {
                        background: #f49829;
                        text-transform: uppercase;
                    }
                }
                @media (max-width: 590px) {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    text-align: left;
                    color: #000000;
                    border: none;
                    border-radius: 4px;
                    width: 100%;
                    padding: 15px;
                    margin-bottom: 2vh;
                    font-size: 18px;

                    &.filter-btn {
                        background: #d6cdc1;
                        text-align: left;
                    }
                    &.search-btn {
                        background: #f49829;
                        text-transform: uppercase;
                        text-align: center;
                        justify-content: center;
                    }
                }
            }
        }

        .filter-attribute-values {
            position: relative;
            .attribute-values {
                background: rgba(0, 0, 0, 0.7);
                color: #ffffff;
                position: absolute;
                left: 0;
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
                @media (max-width: 590px) {
                    width: 50%;
                    z-index: 10;
                    padding-left: 2vh;
                    padding-top: 2vh;
                    background: rgba(59, 59, 55, 0.94);
                    top: -60vh;
                    .attribute-value {
                        width: 100%;
                    }
                }
            }
            .attribute-color {
                height: 30px;
                width: 30px;
                display: inline-block;
                margin: 0 4px;
                cursor: pointer;
                border-radius: 20px;
            }
        }
        .filter-seg {
            padding: 0 10px;
            width: 100%;

            input {
                height: 100%;
            }

            input::placeholder {
                font-size: 16px;
                font-style: italic;
            }
        }
        .filter-seg.logo {
            text-align: center;
            font-size: 24px;
        }

    }
</style>
