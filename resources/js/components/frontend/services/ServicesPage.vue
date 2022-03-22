<template>
    <div class="container">
        <h1 class="title">Услуги</h1>
        <div class="row">
            <div class="col-4 service-wrapper" v-for="group in service_groups">
                <div class="service-card-img" :style="{'background-image': 'url(/storage/images/' + group.images[0].medium+')'}" @click="loadServicePage(group.id)">
                    <span class="group-name">
                        {{group.name}}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            service_groups: Array
        },
        methods: {
            loadServicePage(id) {
                window.open('/services/' + id, '_blank').focus();
            }
        }
    }
</script>
<style lang="scss" scoped>
    .title {
        display: inline-block;
        margin-bottom: 2rem;
        width: 12%;
        padding-bottom: 10px;
        border-bottom: 1px solid #ca7246;
    }
    .service-wrapper {
        margin-bottom: 3rem;
    }
    .service-card-img {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        width: 330px;
        height: 280px;
        cursor: pointer;
        background-position: center;
        background-size: 100%;

        .group-name {
            width: 100%;
            padding: 1rem 0;
            text-align: center;
            color: white;
            font-weight: bold;
            background: rgba(26,27,24,0.51);
        }
    }
</style>
