<template>
    <div class="container">
        <div class="row justify-content-end">
            <a href=""  @click.prevent="markAllAsRead()">
                <ins>Отметить все прочитанными</ins>
            </a>
        </div>
        <div v-if="Object.keys(viewed_notification).length === 0" class="notification-row d-flex flex-column"
             v-for="notification in data" @click="viewNotification(notification)">
            <div>
                <span v-if="notification.status === 'unread'" class="mdi mdi-alert-circle mdi-24px text-primary"></span>
                <strong>{{notification.title}}</strong>
            </div>
            <div>{{truncateMessage(notification.message, 200)}}</div>
            <div class="d-flex">
                <div class="text-light" v-bind:class="'bg-'+tags[notification.tag].class">{{tags[notification.tag].title}}</div>
                <div>{{moment(notification.created_at).format('DD.MM.YY')}}</div>
            </div>
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
                return String(msg).substring(0, max_chars) + ' . . .';
            },
            viewNotification(notification) {
                this.viewed_notification = notification;
                if(notification.status === 'unread') {
                    axios.get('/profile/notification', {
                        params: {
                            id: notification.id
                        }
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
            }
        },
        computed: {

        },
        created() {
            this.notifications = this.data;
        }
    }
</script>
<style lang="scss" scoped>
    .notification-row {
        cursor: pointer;
    }
</style>
