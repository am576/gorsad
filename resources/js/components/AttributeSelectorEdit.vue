<template >
    <div>
        <div>
            <div v-if="item === 1" class="form-row" v-for="(item, index) in rows" :key="index">
                <div class="form-group">
                    <label>Название</label>
                    <select name="attribute_id[]" @change="getAttributeValues($event.target.value, index)" v-model="prop_attributes[index].id">
                        <option value="0">...</option>
                        <option v-for="attribute in attributes" :value="attribute.id">{{attribute.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Значение</label>
                    <select name="attribute_value_id[]" v-model="selected_values[index]">
                        <option value="0">...</option>
                        <option v-for="value in values[index]" :value="value.id">{{value.value}}</option>
                    </select>
                </div>
                <button v-if="index > 0" type="button" class="btn btn-danger delete" tabindex="-1" @click="removeCloned(index)"><i class="mdi mdi-minus"></i></button>
            </div>
            <button type="button" class="btn btn-success clonspan" tabindex="-1" @click="createCloned()"><i class="mdi mdi-plus"></i></button>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

        },
        props: {
            prop_attributes: [],
        },
        data() {
            return {
                rows: [],
                category_id: 0,
                attribute_id: 0,
                attributes: [],
                values: [],
                selected_values: [],
            }
        },
        methods:{
            setCategoryId(id)
            {
                this.category_id = id;
                this.getAttributesForCategory();
            },
            getAttributesForCategory()
            {
                axios.get('/api/getAttributesForCategory', {
                    params: {
                        category_id: this.category_id
                    }
                }).then(response => {
                    this.attributes = response.data;
                    })
            },
            getAttributeValues(attribute_id, index)
            {
                axios.get('/api/getAttributeValues', {
                    params: {
                        attribute_id: attribute_id
                    }
            }).then(response => {
               this.$set(this.values, index, response.data)
                })
            },
            populateAttributes()
            {
                if(this.prop_attributes.length > 0)
                {
                    this.attributes = this.prop_attributes;
                    this.attributes.forEach((attribute, index) => {
                        this.getAttributeValues(attribute.id, index);
                        this.$set(this.selected_values, index, attribute.value_id);
                        this.$set(this.rows, this.rows.length, 1);
                    })
                }
            },
            createCloned()
            {
                this.$set(this.prop_attributes, this.rows.length, {id:0});
                this.$set(this.rows, this.rows.length, 1);
            },
            removeCloned(index)
            {
                this.$set(this.rows, index, 0)
            }
        },
        created: function () {
            this.$eventBus.$on('changeCategory', this.setCategoryId);
            this.populateAttributes();
        }
    }
</script>

