<template>
    <div class="container service-page">
        <h1 class="text-center mt-4 mb-4">{{service_group.name}}</h1>
        <div class="row justify-content-between">
            <div class="col-6">
                <div v-html="service_group.description"></div>
            </div>
            <div class="col-6">
                <img :src="'/storage/images/'+ service_group.images[0].large" alt="">
            </div>
        </div>
        <div class="row justify-content-center" style="margin-top: 3rem;">
            <div class="col-10">
                <div class="row justify-content-center">
                    <b-tabs pills card vertical nav-wrapper-class="service-tabs-wrapper" nav-class="tab-controls" v-model="tabIndex">
                        <b-tab gutters v-for="service in service_group.services" :title="service.name" :key="service.id">
                            <div class="service-description">
                                <div>
                                    <h2 class="text-center">{{service.name}}</h2>
                                    <span v-html="service.description"></span>
                                </div>
                                <div class="mt-3">
                                    <div class="service-price">ОТ {{service.price}} &#8381;</div>
                                    <button class="btn order-service">ЗАКАЗАТЬ</button>
                                </div>

                            </div>
                        </b-tab>
                    </b-tabs>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            service_group: Object
        },
        data() {
            return {
                tabIndex: 0
            }
        }
    }
</script>
<style lang="scss" scoped>
    .service-page {
        margin-bottom: 50px;
        .tab-content {
            height: 400px !important;
        }
        .service-description {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2rem;
            background: #fff6ea;
            color: #515151;
        }
        .service-price {
            width: 90%;
            margin: auto;
            font-size: 2rem;
            text-align: center;
            border-top: 1px solid #ca7246;
        }
        .order-service {
            display: block;
            width: 100%;
            background: #fdcd92;
            border-radius: 0;
            font-size: 1.2rem;
            padding: 1.2rem;
        }
    }


    .card-body {
        height: 100%;
    }
</style>
