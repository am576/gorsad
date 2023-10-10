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
                <div class="row justify-content-center no-gutters">
                    <div class="col-auto service-tabs-wrapper">
                        <ul class="nav nav-pills nav-justified flex-column tab-controls">
                            <li class="nav-item" v-for="service in service_group.services">
                                <a class="nav-link" @click.prevent="setActiveTab(service.name)" :class="{ active: isTabActive(service.name) }" href="#home">{{service.name}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content col" id="myTabContent">
                        <div class="tab-pane fade" :class="{ 'active show': isTabActive(service.name) }" v-for="service in service_group.services">
                            <div class="service-description">
                                <div>
                                    <h2 class="text-center">{{service.name}}</h2>
                                    <span v-html="service.description"></span>
                                </div>
                                <div class="mt-3">
                                    <div class="service-price">ОТ {{service.price}} &#8381;</div>
                                    <button class="btn order-service" @click="showModal(service)">ЗАКАЗАТЬ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <g-modal :id="'service-modal'">
            <form class="h-100" @submit.prevent="orderService">
                <div class="form-text modal-form-caption">- Заказ услуги -</div>
                <div class="form-text font-weight-bold">{{selected_service.name || ''}}</div>
                <input type="text" class="form-control mt-5" placeholder="Имя" required v-model="order.client_name">
                <input type="email" class="form-control" placeholder="E-mail" required v-model="order.client_email">
                <input type="text" class="form-control" placeholder="Телефон" v-model="order.client_phone">
                <button class="btn order-service-modal" type="submit">Оставить заявку</button>
            </form>
        </g-modal>
    </div>
</template>

<script>
    export default {
        props: {
            service_group: Object,
        },
        data() {
            return {
                tabIndex: 0,
                selected_service: {
                    type: Object,
                    default: {}
                },
                order : {},
                activeTab: ''
            }
        },
        methods: {
            showModal(service) {
                this.selected_service = service;
                this.$eventBus.$emit('showModal', 'service-modal');
            },
            setActiveTab(service_name) {
                this.activeTab = service_name;
            },
            isTabActive(service_name) {
                return service_name === this.activeTab;
            },
            async orderService() {
                const formData = new FormData();

                Object.keys(this.order).forEach(key => {
                    formData.append(key, this.order[key])
                });
                try {
                    let res = await axios.post('/services/' + this.selected_service.id + '/order', formData);
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
        created() {
            this.activeTab = this.service_group.services[0].name;
        }
    }
</script>
<style lang="scss" scoped>
    .service-page {
        margin-bottom: 50px;

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
        .btn.order-service-modal {
            background: #ffd59e;
            font-size: 2rem;
            padding: 1rem 2rem;
            margin-top: 1rem;
            color: #5e5e5e;
        }
        .modal-form-caption {
            font-size: 1.5rem;
            color: #5e5e5e;
        }
    }


    .card-body {
        height: 100%;
    }
</style>
