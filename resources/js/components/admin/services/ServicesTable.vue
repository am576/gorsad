<template>
    <div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-hover">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Группа</th>
                    <th>Цена</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(service, index) in services.data" :key="index">
                    <td>{{service.name}}</td>
                    <td>{{service.group.name}}</td>
                    <td>{{service.price}}</td>
                    <td>
                        <table-buttons :table="'services'" :id="service.id"></table-buttons>
                    </td>
                </tr>
                </tbody>
            </table>
            <table-pagination :pagination="services" :offset="4" @paginate="getServices" @changePerPage="changePerPage">
            </table-pagination>
        </div>
    </div>
</template>

<script>
    import moment from "moment";

    export default {
        props: {
            services: {}
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                moment: moment,
                filter_data: [],
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
