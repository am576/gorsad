<template>
    <div class="filter row">
        <div class="filter-group" v-for="group in attributes_groups" :key="group.group_id">
            <div>{{group.group_name}}</div>
            <div v-for="attribute in group.attributes">
                <attribute-button :attribute="attribute"></attribute-button>
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
            }
        },
        created() {
[]        }
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
