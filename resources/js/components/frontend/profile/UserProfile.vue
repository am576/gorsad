<template>
    <div class="row justify-content-center">
        <nav class="col-4">
            <div class="nav nav-tabs flex-column"  id="nav-tab" role="tablist">
                <a class="nav-item nav-item nav-link active" data-toggle="tab" href="#profile_dashboard">МОЙ DASHBOARD</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#profile_queries">ПРЕДЛОЖЕНИЯ</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#profile_orders">ЗАКАЗЫ</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#profile_notifications">
                    УВЕДОМЛЕНИЯ
                    <span v-if="unreadNotificationsCount()" class="text-danger">
                        {{unreadNotificationsCount()}}
                    </span>
                </a>
                <a class="nav-item nav-link" data-toggle="tab" href="#profile_account">ЛИЧНЫЙ КАБИНЕТ</a>
            </div>
        </nav>
        <div class="tab-content col-8" id="nav-tabContent">
            <div class="tab-pane fade show active" role="tabpanel" id="profile_dashboard">
                <h1>ДОБРО ПОЖАЛОВАТЬ, {{user.name}}</h1>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="profile_queries">
                <h4>Мои предложения</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Номер заказа</th>
                        <th>Дата</th>
                        <th>Количество</th>
                        <th>Статус</th>
                        <th>Файл</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="query in user.queries">
                        <td>{{query.id}}</td>
                        <td>{{query.created_at}}</td>
                        <td>{{}}</td>
                        <td>{{query.status}}</td>
                        <td>
                            <a :href="query.quote_file_link">
                                <span class="mdi mdi-file-document"></span>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="profile_orders">Мои заказы</div>
            <div class="tab-pane fade" role="tabpanel" id="profile_notifications">
                <h3>Уведомления</h3>
                <notifications-list :data="user.user_notifications"></notifications-list>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="profile_account">Личный кабинет</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: {
                type: Object
            }
        },
        data() {
            return {
                user: {}
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
        mounted() {
        },
        created() {
            this.user = this.data;
            this.$eventBus.$on('setNotificationRead', this.setNotificationRead);
            this.$eventBus.$on('setAllNotificationsRead', this.setAllNotificationsRead);
        }
    }
</script>
