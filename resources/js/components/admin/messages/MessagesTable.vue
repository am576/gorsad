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
                <tr v-for="(message, index) in messages" :key="index">
                    <td>{{message.name}}</td>
                    <td>{{message.email}}</td>
                    <td>{{message.phone}}</td>
                    <td>{{message.message}}</td>
                </tr>
                </tbody>
            </table>
            <!--<table-pagination :pagination="messages" :offset="4" @paginate="getServices" @changePerPage="changePerPage">
            </table-pagination>-->
        </div>
    </div>
</template>

<script>
    import moment from "moment";

    export default {
        props: {
            messages: {}
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                moment: moment,
                per_page: 10
            }
        },
        methods: {
            getServices(page_number) {
                axios.get('/api/paginateServices', {
                        params: {
                            page: page_number,
                            per_page: this.per_page
                        }
                    }
                )
                    .then(response => {
                        this.services = response.data;
                    })
            },
            changePerPage(per_page) {
                this.per_page = per_page;
                this.getServices(this.services.current_page);
            },
        }
    }
</script>
