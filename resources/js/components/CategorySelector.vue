<template>
        <select name="category_id" id="category_id">
            <option v-for="category in categories" :value="category.id" :key="category.id">{{category.title}}</option>
        </select>
</template>

<script>
    export default {
        props : ['categories']
    }
</script>

<style scoped>

</style>
