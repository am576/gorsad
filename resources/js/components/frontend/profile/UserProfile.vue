<template>
    <div class="row justify-content-center">
        <b-card no-body class="col-12 p-0">
            <b-tabs pills card vertical nav-wrapper-class="w-25" v-model="tabIndex">
                <b-tab title="МОЙ DASHBOARD" active><b-card-text></b-card-text></b-tab>
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
                        </b-table>
                        <b-pagination
                            v-model="currentOrdersPage"
                            :total-rows="orders_table_data.items.length"
                            :per-page="perPage"
                        ></b-pagination>
                    </b-card-text>
                </b-tab>
                <b-tab title="ИЗБРАННОЕ">
                    <b-card-text>
                        <favorites-list :data="user.favorites"></favorites-list>
                    </b-card-text>
                </b-tab>
                <b-tab>
                    <template #title>
                        УВЕДОМЛЕНИЯ
                        <span v-if="unreadNotificationsCount()" class="text-danger">
                        {{unreadNotificationsCount()}}
                    </span>
                    </template>
                    <b-card-text>
                        <h4>Уведомления</h4>
                        <notifications-list :data="user.user_notifications"></notifications-list>
                    </b-card-text>
                </b-tab>
                <b-tab title="ЛИЧНЫЙ КАБИНЕТ">
                    <b-card-text>
                        <user-cabinet :data="user.companies"></user-cabinet>
                    </b-card-text>
                </b-tab>
            </b-tabs>
        </b-card>
        <!--<div class="tab-content col-8" id="nav-tabContent">
            <div class="tab-pane fade show active" role="tabpanel" id="profile_dashboard">
                <h1>ДОБРО ПОЖАЛОВАТЬ, {{user.name}}</h1>
            </div>

            <div class="tab-pane fade" role="tabpanel" id="profile_notifications">
                <h3>Уведомления</h3>
                <notifications-list :data="user.user_notifications"></notifications-list>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="profile_account">Личный кабинет</div>
        </div>-->
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
                perPage: 5,
                currentOrdersPage: 1,
                currentQueriesPage: 1,
                tabIndex: this.tab
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
            }
        },
        computed: {
            queries_table_data() {
                let labels = [
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
                        created_at: moment(query.created_at).format('DD.MM.YY'),
                    })
                })

                return {
                    fields: labels,
                    items: queries
                }
            },
            orders_table_data() {
                let labels = [
                    {key: 'id', label: 'Номер заказа', sortable: true},
                    {key: 'products_count', 'label': 'Количество'},
                    {key: 'status', 'label': 'Статус'},
                    {key: 'file', 'label': 'PDF'},
                    {key: 'created_at', label: 'Дата', sortable: true},
                ];
                let orders = [];
                this.user.orders.forEach(order => {
                    orders.push({
                        id: String(order.query_id).padStart(8, '0'),
                        products_count: order.products_count,
                        status: order.status,
                        file: order.id,
                        created_at: moment(order.created_at).format('DD.MM.YY'),
                    })
                })

                return {
                    fields: labels,
                    items: orders
                }
            },
        },
        mounted() {
            this.$nextTick(() => this.tabIndex = this.tab)
        },
        created() {
            this.user = this.data;
            // this.tabIndex = this.tab;
            this.$eventBus.$on('setNotificationRead', this.setNotificationRead);
            this.$eventBus.$on('setAllNotificationsRead', this.setAllNotificationsRead);
        }
    }
</script>
