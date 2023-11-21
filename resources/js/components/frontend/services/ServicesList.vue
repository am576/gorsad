<template>
    <div class="sg-services">
        <div class="services-list">
            <div class="services-links-wr">
                <div class="services-links">
                    <div class="service-link" v-for="service in services" @click="setServiceActive(service)">
                        <span class="active-marker" :style="{opacity: isServiceActive(service)}">></span>
                        <span>{{service.name}}</span>
                    </div>
                </div>
            </div>
            <div class="service-description" >
                <div class="service-name">{{active_service.name}}</div>
                <div v-html="active_service.description"></div>
            </div>
        </div>
        <div class="order-service">
            <div class="price">ОТ {{active_service.price}} <span class="currency">&#8381;</span></div>
            <button class="order-service-btn btn-green no-border-radius">Заказать</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            services: {
                type: Array
            }
        },
        data() {
            return {
                active_service: this.services[0]
            }
        },
        methods: {
            setServiceActive(service) {
                this.active_service = service;
            },
            isServiceActive(service) {
                return service.id === this.active_service.id ? 1 : 0;
            }
        },

    }
</script>

<style lang="scss" scoped>
@import '@/_variables.scss';
    .sg-services {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        .services-list {
            display: flex;
            font: 400 18px 'Inter', sans-serif;
            line-height: 27px;
            color: $text-color;
            .services-links-wr {
                display: flex;
                flex: 1;
                justify-content: center;
                .services-links {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    gap: 20px;
                    .service-link {
                        cursor: pointer;
                        font-weight: 600;
                        display: flex;
                        .active-marker {
                            margin-right: 15px;
                            font-weight: 400;
                        }
                    }
                }
            }
        }
        .service-description {
            flex: 1;
            .service-name {
                margin-bottom: 35px;
                font-size: 25px;
                font-weight: 600;
            }
        }
        .order-service {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            margin-top: 40px;
            margin-bottom: 55px;
            .price {
                margin-bottom: 30px;
                font: 400 18px 'Inter', sans-serif;
                color: $text-color;
                .currency {
                    opacity: 0.6;
                }
            }
            .order-service-btn {
                width: 50%;
                padding: 16px 100px !important;
            }
        }
    }
</style>
