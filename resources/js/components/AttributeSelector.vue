<template>
    <div class="form-row">
        <div class="form-group">
            <label for="attribute_id">Название</label>
            <select name="attribute_id" id="attribute_id" v-model="attribute_id" @change="getAttributeValues">
                <option value="0">...</option>
                <option v-for="attribute in attributes" :value="attribute.id">{{attribute.name}}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="attribute_value">Значеник</label>
            <select name="attribute_value" id="attribute_value">
                <option value="0">...</option>
                <option v-for="value in values" :value="value.id">{{value.value}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Attribute selector mounted')
        },
        data() {
            return {
                category_id: 0,
                attributes: [],
                attribute_id: 0,
                values: []
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
                }).then((response) => {
                    this.attributes = response.data;
                    })
            },
            getAttributeValues()
            {
                axios.get('/api/getAttributeValues', {
                    params: {
                        attribute_id: this.attribute_id
                    }
            }).then((response) => {
                this.values = response.data;
                console.log(response.data);
                })
            }
        },
        created: function () {
            this.$eventBus.$on('changeCategory', this.setCategoryId)
        }
    }
</script>

