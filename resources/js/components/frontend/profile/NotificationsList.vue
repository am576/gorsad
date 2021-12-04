<template>
    <div class="container">
        <div v-if="unreadNotificationsCount" class="row justify-content-end">
            <a href=""  @click.prevent="markAllAsRead()">
                <ins>Отметить все прочитанными</ins>
            </a>
        </div>
        <div v-if="Object.keys(viewed_notification).length === 0">
            <div class="notification-row d-flex flex-column"
                 v-for="(notification, index) in paginatedNotifications" @click="viewNotification(notification)"
                 :key="index">
                <div>
                    <span v-if="notification.status === 'unread'"
                          class="mdi mdi-alert-circle mdi-24px text-primary"></span>
                    <strong>{{notification.title}}</strong>
                </div>
                <div class="mt-3 mb-3">{{truncateMessage(notification.message, 200)}}</div>
                <div class="d-flex">

                    <div class="font-italic">{{moment(notification.created_at).format('DD.MM.YY hh:mm')}}</div>
                </div>
            </div>
            <b-pagination
                @change="onPageChanged"
                :total-rows="total_rows"
                :per-page="perPage"
                v-model="currentPage"
                class="my-0"
            />
        </div>
        <div v-if="Object.keys(viewed_notification).length" class="notification-full d-flex flex-column">
            <div>
                <strong>{{viewed_notification.title}}</strong>
            </div>
            <div>{{viewed_notification.message}}</div>
            <div class="d-flex">
                <div class="text-light" v-bind:class="'bg-'+tags[viewed_notification.tag].class">{{tags[viewed_notification.tag].title}}</div>
                <div>{{moment(viewed_notification.created_at).format('DD.MM.YY')}}</div>
            </div>
            <div class="text-center">
                <a href=""  @click.prevent="clearViewedNotification()">
                    <ins>Назад</ins>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    export default {
        props: {
            data: {
                type: Array
            }
        },
        data() {
            return {
                moment: moment,
                notifications: [],
                paginatedNotifications: [],
                currentPage: 1,
                perPage: 5,
                viewed_notification: {},
                tags: {
                    'important' : {
                        'title' : 'Важное',
                        'class' : 'danger'
                    },
                    'info' : {
                        'title' : 'Информация',
                        'class' : 'warning'
                    },
                    'proposition' : {
                        'title' : 'Предложение',
                        'class' : 'info'
                    },
                }
            }
        },
        methods: {
            truncateMessage(msg, max_chars) {
                return msg.length >= max_chars ? String(msg).substring(0, max_chars) + ' . . .' : msg;
            },
            viewNotification(notification) {
                this.viewed_notification = notification;
                if(notification.status === 'unread') {
                    axios.post('/profile/notification', {
                            id: notification.id
                    }).then(res =>{
                        notification.status = 'read';
                        this.$eventBus.$emit('setNotificationRead', notification.id)
                    })
                }
            },
            markAllAsRead() {
                axios.get('/profile/notification/readall')
                .then(() => {
                    this.$eventBus.$emit('setAllNotificationsRead');
                })
            },
            clearViewedNotification() {
                this.viewed_notification = {};
            },
            paginate(per_page, page_number) {
                let itemsToParse = this.notifications;
                this.paginatedNotifications = itemsToParse.slice(
                    (page_number - 1) * per_page,
                     page_number  * per_page
                );
            },
            onPageChanged(page_number) {
                this.paginate(this.perPage, page_number);
            },
        },
        computed: {
            total_rows() {
                return this.notifications.length;
            },
            unreadNotificationsCount() {
                let count = 0;
                this.notifications.forEach(notification => {
                    if(notification.status === 'unread') {
                        count++;
                    }
                })

                return count;
            },
        },
        mounted() {
            this.paginate(this.perPage, 1);
        },
        created() {
            this.notifications = this.data;
        }
    }
</script>
<style lang="scss" scoped>
    .notification-row {
        cursor: pointer;
        margin-bottom: 25px;
        padding: 10px 30px 15px;
        border: 1px #d2d2d2 solid;
        border-radius: 5px;
        background-color: #fff;
    }

</style>
