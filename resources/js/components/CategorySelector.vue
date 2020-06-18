<template>
        <select name="category_id" id="category_id" @change="changeCategory" v-model="category_id">
            <option value="0">...</option>
            <option v-for="category in categories" :value="category.id" :key="category.id">{{category.title}}</option>
        </select>
</template>

<script>
    export default {
        mounted() {
            console.log('Category selector mounted')
        },
        props: {
          children_only: Boolean,
            category : 0,
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
            this.getChildCategories();
            else
                this.getAllCategories()
        }
    }
</script>

