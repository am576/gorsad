<template>
    <div>
        <div class="table-responsive">
            <table id="dataTable" class="table">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Сообщение</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(message, index) in messages.data" :key="index">
                    <td>{{message.name}}</td>
                    <td>{{message.email}}</td>
                    <td>{{message.phone}}</td>
                    <td width="600">{{message.message}}</td>
                </tr>
                </tbody>
            </table>
            <table-pagination :pagination="messages" :offset="4" @paginate="getMessages" @changePerPage="changePerPage"/>
        </div>
    </div>
</template>

<script>
    import moment from "moment";

    export default {
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                moment: moment,
                per_page: 10,
                messages: {
                  total: 0,
                  per_page: 2,
                  from: 1,
                  to: 0,
                  current_page: 1
              },
            }
        },
        methods: {
            getMessages(page_number) {
                axios.get('/api/paginateMessages', {
                        params: {
                            page: page_number,
                            per_page: this.per_page
                        }
                    }
                )
                    .then(response => {
                        this.messages = response.data;
                    })
            },
            changePerPage(per_page) {
                this.per_page = per_page;
                this.getMessages(this.messages.current_page);
            },
        },
        created() {
            this.getMessages();
        }
    }
</script>
