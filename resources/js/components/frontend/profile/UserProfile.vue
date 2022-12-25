<template>
    <div class="row justify-content-center">
        <div class="card col-12 p-0">
            <div class="tabs row no-gutters">
                <div class="col-auto profile-tabs-wrapper">
                    <ul class="nav nav-pills flex-column card-header h-100 border-bottom-0 rounded-0 tab-controls">
                        <li class="nav-item" v-for="(tab, tab_name) in tabs">
                            <a class="nav-link" href="#" @click.prevent="setActiveTab(tab_name)" :class="{active: isTabActive(tab_name)}">
                                {{tab.tab_name}}
                                <span v-if="tab.hasBadge">
                                    <b-badge v-if="call(tab.badge_content)" variant="light">{{call(tab.badge_content)}}</b-badge>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content col">
                    <div class="tab-pane card-body" :class="{active: isTabActive('queries')}">
                        <div class="card-text">
                            <b-table :fields="tabs.queries.data.fields" :items="tabs.queries.data.items" :per-page="perPage"
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
                                :total-rows="tabs.queries.data.items.length"
                                :per-page="perPage"
                            ></b-pagination>
                        </div>
                    </div>
                    <div class="tab-pane card-body" :class="{active: isTabActive('orders')}">
                        <div class="card-text">
                            <b-table :fields="tabs.orders.data.fields"
                                     :items="tabs.orders.data.items"
                                     :per-page="perPage"
                                     :current-page="currentOrdersPage"
                            >
                                <template #cell(file)="data">
                                    <a :href="'/orderpdf?id='+data.value">
                                        <span class="mdi mdi-file-document"></span>
                                    </a>
                                </template>
                                <template #cell(status)="data">
                                    <b-badge :variant="order_status[data.value].color">{{order_status[data.value].loc}}</b-badge>
                                </template>
                                <template #cell(sum)="data">
                                    <span>{{data.item.sum}} &#8381;</span>
                                </template>
                                <template #cell(buy)="data">
                                    <button class="btn btn-primary" v-if="data.item.status === 'new'" @click="showOrderDetails(data.item)">Открыть</button>
                                </template>
                            </b-table>
                            <b-pagination
                                v-model="currentOrdersPage"
                                :total-rows="tabs.orders.data.items.length"
                                :per-page="perPage"
                            ></b-pagination>
                        </div>
                    </div>
                    <div class="tab-pane card-body" :class="{active: isTabActive('notifications')}">
                        <div class="card-text">
                            <notifications-list :data="user.user_notifications"></notifications-list>
                        </div>
                    </div>
                    <div class="tab-pane card-body" :class="{active: isTabActive('bonuses_history')}">
                        <div class="card-text">
                            <h4>Баллы - {{user.bonuses}}</h4>
                            <h5 class="text-center mt-3">История</h5>
                            <b-table :fields="tabs.bonuses_history.data.fields" :items="tabs.bonuses_history.data.items" :per-page="perPage"
                                     :current-page="currentBonusesPage">
                            </b-table>
                            <b-pagination
                                v-model="currentBonusesPage"
                                :total-rows="tabs.bonuses_history.data.items.length"
                                :per-page="perPage"
                            ></b-pagination>
                        </div>
                    </div>
                    <div class="tab-pane card-body" :class="{active: isTabActive('favorites')}">
                        <div class="card-text">
                            <favorites-list :favorites="user.favorites"></favorites-list>
                        </div>
                    </div>
                    <div class="tab-pane card-body" :class="{active: isTabActive('user_cabinet')}">
                        <div class="card-text">
                            <user-cabinet :data="user"></user-cabinet>
                        </div>
                    </div>
                </div>
            </div>
            <g-modal :id="'order-modal'" ref="orderModal" :modal_class="'order-modal'">
                <template v-slot:header>
                    <header class="modal-header align-items-center justify-content-md-between justify-content-start">
                        <h4 class="modal-title justify-content-start">
                            Заказ #{{selected_order.id}}
                        </h4>
                        <a href="#" @click="cancelOrder(selected_order.id)">Отменить заказ</a>
                    </header>
                </template>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="row w-100" v-for="product in selected_order.products">
                            <!--<img :src="'/storage/images/' + product.image.icon">-->
                            <div class="col-3">
                                {{product.custom_name || product.title}}
                            </div>
                            <div class="col-3">
                                {{product.custom_price}} &#8381;
                            </div>
                            <div class="col-3">
                                {{product.quantity}}
                            </div>
                            <div class="col-3">
                                {{product.sum}} &#8381;
                            </div>
                        </div>
                        <div class="row w-100">
                            {{selected_order.sum_total}} &#8381;
                        </div>
                        <div class="row w-100 justify-content-center">
                            <button type="button" class="btn-primary btn btn-blue btn-lg">Получить счёт на оплату</button>
                        </div>
                    </div>
                </div>
            </g-modal>
        </div>
    </div>
</template>

<script>
    import moment from "moment";

    export default {
        props: {
            data: {},
            tab: '',
        },
        data() {
            return {
                moment: moment,
                user: {},
                company: {},
                company_id: 0,
                perPage: 10,
                currentOrdersPage: 1,
                currentQueriesPage: 1,
                currentBonusesPage: 1,
                selected_order: {},
                tabIndex: '',
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
                tabs: {
                    queries: {
                        tab_name: 'ЗАПРОСЫ',
                        data: {}
                    },
                    orders: {
                        tab_name: 'ЗАКАЗЫ',
                    },
                    bonuses_history: {
                        tab_name: 'БАЛЛЫ',
                    },
                    notifications: {
                        tab_name: 'УВЕДОМЛЕНИЯ',
                        hasBadge: true,
                        badge_content: 'this.unreadNotificationsCount',
                        data: {}
                    },
                    favorites: {
                        tab_name: 'ИЗБРАННОЕ',
                        hasBadge: true,
                        badge_content: 'this.favoritesCount',
                        data: {}
                    },
                    user_cabinet: {
                        tab_name: 'ЛИЧНЫЙ КАБИНЕТ',
                        hasBadge: false,
                        data: {}
                    }
                },
                active_tab: '',
            }
        },
        methods: {
            showOrderDetails(order) {
                axios.get('/user/orders/' + order.id)
                .then((response) => {
                    this.selected_order = response.data;
                })
                this.$eventBus.$emit('showModal', 'order-modal');
            },
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
            setActiveTab(tab) {
                this.active_tab = tab;
            },
            isTabActive(tab) {
                return tab === this.active_tab;
            },
            fillTableData() {
                this.fillQueriesTableData();
                this.fillOrdersTableData();
                this.fillBonusesTableData();
            },
            fillQueriesTableData() {
                const labels = [
                    {key: 'id', label: 'Номер заказа', sortable: true},
                    {key: 'products_count', 'label': 'Количество'},
                    {key: 'status', 'label': 'Статус'},
                    // {key: 'file', 'label': 'PDF'},
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
                this.tabs.queries.data = {
                    fields: labels,
                    items: queries
                }
            },
            fillOrdersTableData() {
                const labels = [
                    {key: 'id', label: 'Номер заказа', sortable: true},
                    {key: 'products_count', 'label': 'Количество'},
                    {key: 'sum', 'label': 'Сумма'},
                    {key: 'status', 'label': 'Статус'},
                    // {key: 'file', 'label': 'PDF'},
                    {key: 'created_at', label: 'Дата', sortable: true},
                    {key: 'buy', 'label': '', sortable: false},
                ];
                let orders = [];
                this.user.orders.forEach(order => {
                    orders.push({
                        id: String(order.id).padStart(8, '0'),
                        products_count: order.products_count,
                        sum: order.sum,
                        status: order.status,
                        file: order.id,
                        created_at: moment(order.created_at).format('DD.MM.YY hh:mm'),
                    })
                })

                if(this.isMobileView) {
                    labels.splice(1,1);
                    orders.splice(1,1);
                }

                this.tabs.orders.data = {
                    fields: labels,
                    items: orders
                }
            },
            fillBonusesTableData() {
                const labels = [
                    // {key: 'order', label: 'Заказ'},
                    {key: 'bonuses', label: 'Баллы'},
                    {key: 'created_at', label: 'Дата'},
                ]
                let history = [];
                this.user.bonuses_history.forEach(entry => {
                    history.push({
                        // 'order' : entry.order_id,
                        'bonuses' : entry.bonuses > 0 ? '+'+entry.bonuses : entry.bonuses,
                        'created_at' : moment(entry.created_at).format('DD.MM.YY hh:mm')
                    })
                })
                this.tabs.bonuses_history.data = {
                    fields: labels,
                    items: history
                }
            },
            cancelOrder(id) {
                if(confirm('Вы уверены, что хотите отменить этот заказ?')) {
                    axios.post(`user/orders/${id}/cancel`)
                        .then(response => {
                            console.log(response.data);
                        })
                }
            },
            call(fn) {
                return eval(fn)
            },
        },

        computed: {
            profileTitle() {
                return this.company.id ? this.company.name : this.user.name
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
            favoritesCount() {
                return this.user.favorites.length;
            }
        },
        mounted() {
            // this.$nextTick(() => this.tabIndex = this.tab);
        },
        created() {
            this.user = this.data;
            this.fillTableData();
            this.$eventBus.$on('setNotificationRead', this.setNotificationRead);
            this.$eventBus.$on('setAllNotificationsRead', this.setAllNotificationsRead);
            this.$eventBus.$on('changeLoginType', this.changeLoginType);
            this.activeCompanyId();
            this.handleView();
            this.setActiveTab(this.tab.toString());
            document.title += ' | Личный кабинет';
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
