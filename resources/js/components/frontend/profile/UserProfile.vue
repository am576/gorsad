<template>
    <div class="row justify-content-center">
        <b-card no-body class="col-12 p-0">
            <div id="profile-title">{{profileTitle}}</div>
            <b-tabs pills card vertical nav-wrapper-class="profile-tabs-wrapper" nav-class="tab-controls" v-model="tabIndex">
                <b-tab title="ЗАПРОСЫ">
                    <b-card-text>
                        <h4>Мои запросы</h4>
                        <b-table :fields="queries_table_data.fields" :items="queries_table_data.items" :per-page="perPage"
                                 :current-page="currentQueriesPage">
                            <template #cell(file)="data">
                                <a :href="'/querypdf?id='+data.value">
                                    <span class="mdi mdi-file-document"></span>
                                </a>
                            </template>
                            <template #cell(status)="data">
                                <b-badge :variant="query_status[data.value].color">{{query_status[data.value].loc}}</b-badge>
                            </template>
                        </b-table>
                        <b-pagination
                            v-model="currentQueriesPage"
                            :total-rows="queries_table_data.items.length"
                            :per-page="perPage"
                        ></b-pagination>
                    </b-card-text>
                </b-tab>
                <b-tab title="ЗАКАЗЫ">
                    <b-card-text>
                        <h4>Мои заказы</h4>
                        <b-table :fields="orders_table_data.fields" :items="orders_table_data.items" :per-page="perPage"
                                 :current-page="currentOrdersPage">
                            <template #cell(file)="data">
                                <a :href="'/orderpdf?id='+data.value">
                                    <span class="mdi mdi-file-document"></span>
                                </a>
                            </template>
                            <template #cell(status)="data">
                                <b-badge :variant="order_status[data.value].color">{{order_status[data.value].loc}}</b-badge>
                            </template>
                            <template #cell(buy)="data" v-if="company_id === 0">
                                <b-button variant="primary" v-b-modal.my-modal>Оплата</b-button>
                                <b-modal id="my-modal" size="md" title="Оплата заказа" ok-only>
                                    <b-container fluid>
                                        <b-row>
                                            <div class="mb-2" style="font-size: 20px;">Выберите вариант оплаты.</div>
                                        </b-row>
                                        <b-row class="mb-3">
                                            <b-card class="w-100">
                                                <b-card-text class="pay-option f-20">Картой онлайн</b-card-text>
                                            </b-card>
                                        </b-row>
                                        <b-row class="mb-3">
                                            <b-card class="w-100">
                                                <b-card-text class="pay-option f-20">Google Pay</b-card-text>
                                            </b-card>
                                        </b-row>
                                        <b-row class="mb-3">
                                            <b-card class="w-100">
                                                <b-card-text class="pay-option f-20">QR-код</b-card-text>
                                            </b-card>
                                        </b-row>
                                        <b-row class="mb-3">
                                            <b-card class="w-100">
                                                <b-card-text class="pay-option f-20">Apple Pay</b-card-text>
                                            </b-card>
                                        </b-row>
                                        <b-row class="mb-3">
                                            <b-card class="w-100">
                                                <b-card-text class="pay-option f-20">Банковский перевод</b-card-text>
                                            </b-card>
                                        </b-row>
                                    </b-container>
                                </b-modal>
                            </template>
                        </b-table>
                        <b-pagination
                            v-model="currentOrdersPage"
                            :total-rows="orders_table_data.items.length"
                            :per-page="perPage"
                        ></b-pagination>
                    </b-card-text>
                </b-tab>
                <b-tab id="notification-tab">
                    <template #title>
                        УВЕДОМЛЕНИЯ
                        <b-badge v-if="unreadNotificationsCount()" variant="light">{{unreadNotificationsCount()}}</b-badge>
                    </template>
                    <b-card-text>
                        <notifications-list :data="user.user_notifications"></notifications-list>
                    </b-card-text>
                </b-tab>
                <b-tab title="БАЛЛЫ">
                    <b-card-text>
                        <h4>Баллы - {{user.bonuses}}</h4>
                        <b-table :fields="bonuses_table_data.fields" :items="bonuses_table_data.items" :per-page="perPage"
                                 :current-page="currentQueriesPage">
                        </b-table>
                    </b-card-text>
                </b-tab>
                <b-tab title="ИЗБРАННОЕ">
                    <b-card-text>
                        <favorites-list :data="user.favorites"></favorites-list>
                    </b-card-text>
                </b-tab>
                <b-tab title="ЛИЧНЫЙ КАБИНЕТ">
                    <b-card-text>
                        <user-cabinet :data="user"></user-cabinet>
                    </b-card-text>
                </b-tab>
            </b-tabs>
        </b-card>
    </div>
</template>

<script>
    import moment from "moment";
    export default {
        props: {
            data: {
                type: Object
            },
            tab: 0
        },
        data() {
            return {
                moment: moment,
                user: {},
                company: {},
                company_id: 0,
                perPage: 5,
                currentOrdersPage: 1,
                currentQueriesPage: 1,
                tabIndex: this.tab,
                isMobileView: false,
                query_status : {
                    'new': {
                        loc: 'новый',
                        color: 'primary'
                    },
                    'processing': {
                        loc: 'в обработке',
                        color: 'info'
                    },
                    'approved': {
                        loc: 'одобрен',
                        color: 'success'
                    },
                    'cancelled': {
                        loc: 'отменён',
                        color: 'danger'
                    }
                },
                order_status : {
                    'new': {
                        loc: 'новый',
                        color: 'primary'
                    },
                    'accepted': {
                        loc: 'в обработке',
                        color: 'info'
                    },
                    'closed': {
                        loc: 'завершён',
                        color: 'success'
                    },
                    'canceled': {
                        loc: 'отменён',
                        color: 'danger'
                    }
                },
            }
        },
        methods: {
            setNotificationRead(id) {
                this.user.user_notifications.forEach((notification, index) => {
                    if(notification.id === id) {
                        this.$set(this.user.user_notifications[index], 'status', 'read');
                        this.unreadNotificationsCount();
                    }
                })
            },
            setAllNotificationsRead() {
                this.user.user_notifications.forEach((notification, index) => {
                    if(notification.status === 'unread') {
                        this.$set(this.user.user_notifications[index], 'status', 'read');
                        this.unreadNotificationsCount();
                    }
                })
            },
            unreadNotificationsCount() {
                let count = 0;
                this.user.user_notifications.forEach(notification => {
                    if(notification.status === 'unread') {
                        count++;
                    }
                })

                return count;
            },
            changeLoginType(newType, companyId) {
                if(newType === 'user') {
                    this.company_id = 0
                }
                else if(newType == 'company') {
                    this.company_id = companyId;
                }
            },
            activeCompanyId() {
                this.user.companies.forEach(company => {
                    if(company.is_active === 1)
                    {
                        this.company = company;
                        this.company_id = company.id;
                    }
                })
            },
            handleView() {
                this.isMobileView = window.innerWidth <= 590;
            },
        },
        computed: {
            queries_table_data() {
                const labels = [
                    {key: 'id', label: 'Номер заказа', sortable: true},
                    {key: 'products_count', 'label': 'Количество'},
                    {key: 'status', 'label': 'Статус'},
                    {key: 'file', 'label': 'PDF'},
                    {key: 'created_at', label: 'Дата', sortable: true},
                ];
                let queries = [];
                this.user.queries.forEach(query => {
                    queries.push({
                        id: String(query.id).padStart(8, '0'),
                        products_count: query.products_count,
                        status: query.status,
                        file: query.id,
                        created_at: moment(query.created_at).format('DD.MM.YY hh:mm'),
                    })
                })

                if(this.isMobileView) {
                    labels.splice(1,1);
                    queries.splice(1,1);
                }
                return {
                    fields: labels,
                    items: queries
                }
            },
            orders_table_data() {
                const labels = [
                    {key: 'id', label: 'Номер заказа', sortable: true},
                    {key: 'products_count', 'label': 'Количество'},
                    {key: 'status', 'label': 'Статус'},
                    {key: 'file', 'label': 'PDF'},
                    {key: 'created_at', label: 'Дата', sortable: true},
                    {key: 'buy', 'label': '', sortable: false},
                ];
                let orders = [];
                this.user.orders.forEach(order => {
                    orders.push({
                        id: String(order.query_id).padStart(8, '0'),
                        products_count: order.products_count,
                        status: order.status,
                        file: order.id,
                        created_at: moment(order.created_at).format('DD.MM.YY hh:mm'),
                    })
                })

                if(this.isMobileView) {
                    labels.splice(1,1);
                    orders.splice(1,1);
                }

                return {
                    fields: labels,
                    items: orders
                }
            },
            bonuses_table_data() {
                const labels = [
                    {key: 'product_name', label: 'Товар'},
                    {key: 'bonuses', label: 'Баллы'},
                    {key: 'created_at', label: 'Дата'},
                ]
                let history = [];
                this.user.bonuses_history.forEach(entry => {
                    history.push({
                        'product_name' : entry.title,
                        'bonuses' : entry.bonuses,
                        'created_at' : moment(entry.created_at).format('DD.MM.YY hh:mm')
                    })
                })
                return {
                    fields: labels,
                    items: history
                }
            },
            profileTitle() {
                return this.company.id ? this.company.name : this.user.name
            }
        },
        mounted() {
            this.$nextTick(() => this.tabIndex = this.tab);
        },
        created() {
            this.user = this.data;
            this.$eventBus.$on('setNotificationRead', this.setNotificationRead);
            this.$eventBus.$on('setAllNotificationsRead', this.setAllNotificationsRead);
            this.$eventBus.$on('changeLoginType', this.changeLoginType);
            this.activeCompanyId();
            this.handleView();
        }
    }
</script>
<style lang="scss" scoped>
    .f-20 {
        font-size: 18px !important;
    }
    .pay-option {
        cursor: pointer;
    }
    #notification-tab {
        background-color: #eee !important;
    }
    #profile-title {
        font-size: 40px;
        text-align: center;
    }

</style>
