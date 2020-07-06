<template>
        <select :name="select_name" id="category_id" @change="changeCategory" v-model="category_id">
            <option value="0">...</option>
            <option v-for="category in categories" :value="category.id" :key="category.id">{{category.title}}</option>
        </select>
</template>

<script>
    export default {
        props: {
            children_only: Boolean,
            except_self: Boolean,
            category : 0,
            parent_id: 0,
            select_name: {
                type: String,
                default: 'category_id',
            }
        },
        data() {
            return {
                category_id : 0,
                categories : []
            }
        },
        methods:{
            getChildCategories: function(){
                axios.get('/api/getChildCategories')
                    .then((response) => {
                        this.categories = response.data;
                    })
            },
            getAllCategories: function(){
                axios.get('/api/getAllCategories')
                    .then((response) => {
                        this.categories = response.data;
                    })
            },
            getCategoriesExceptSelf() {
                axios.get('/api/getCategoriesExceptSelf', {
                    params: {
                        id: this.category_id
                    }
                })
                    .then((response) => {
                        this.categories = response.data;
                    })
            },
            changeCategory()
            {
                this.$eventBus.$emit('changeCategory', this.category_id)
            }
        },
        created: function () {
            if(this.category)
            {
                this.category_id = this.category;
            }
            if(this.children_only)
            {
                this.getChildCategories();
            }
            else if(this.except_self)
            {
                this.getCategoriesExceptSelf()
            }
            else
            {
                this.getAllCategories()
            }
            if(this.parent_id)
            {
                this.category_id = this.parent_id
            }
        }
    }
</script>

