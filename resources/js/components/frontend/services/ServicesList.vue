<template>
    <div class="sg-services">
        <div class="services-list">
            <div class="services-links-wr">
                <div class="services-links">
                    <div class="service-link" v-for="service in services" @click="setServiceActive(service)">
                        <span class="active-marker" :style="{opacity: isServiceActive(service)}">
                            <i class="mdi mdi-chevron-right mdi-24px"></i>
                        </span>
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
            <button class="order-service-btn btn-green no-border-radius" @click="showModal(active_service)">Заказать</button>
        </div>
        <g-modal :id="'service-modal'">
            <form id="order-service" class="h-100" @submit.prevent="orderService">
                <div class="form-text modal-form-caption">- Заказ услуги -</div>
                <div class="form-text font-weight-bold">{{active_service.name || ''}}</div>
                <div class="form-group">
                    <input type="text" class="form-control mt-5" placeholder="Имя" required v-model="order.client_name">
                    <input type="email" class="form-control" placeholder="E-mail" required v-model="order.client_email">
                    <input type="text" class="form-control" placeholder="Телефон" v-model="order.client_phone">
                </div>
                <button class="btn btn-green order-service-modal" type="submit">Оставить заявку</button>
            </form>
        </g-modal>
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
                active_service: this.services[0],
                order : {}
            }
        },
        methods: {
            setServiceActive(service) {
                this.active_service = service;
            },
            isServiceActive(service) {
                return service.id === this.active_service.id ? 1 : 0;
            },
            showModal(service) {
                this.active_service = service;
                this.$eventBus.$emit('showModal', 'service-modal');
            },
            async orderService() {
                const formData = new FormData();

                Object.keys(this.order).forEach(key => {
                    formData.append(key, this.order[key])
                });
                try {
                    let res = await axios.post('/services/' + this.active_service.id + '/order', formData);
                    if(res.status === 200) {
                        alert('Спасибо! Ваша заявка принята. В ближайшее время с Вами свяжется наш менеджер для уточнения деталей');
                        window.location.reload();
                    }
                }
                catch(error) {
                    alert(error.response.statusText + ' - ' + error.response.status)
                }
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
        form#order-service {
            text-align: center;
            padding: 20px 0;
            input {
                width: 70%;
            }
            .form-group {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }
            
        }
    }
</style>
