<template>
    <div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-hover">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Место</th>
                    <th>Площадь</th>
                    <th>Заказчик</th>
                    <th>Исполнитель</th>
                    <th>Растения</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(project, index) in projects.data" :key="index">
                    <td>{{project.name}}</td>
                    <td>{{project.place}}</td>
                    <td>{{project.area}}</td>
                    <td>{{project.client}}</td>
                    <td>{{project.doneby}}</td>
                    <td></td>
                    <td>
                        <table-buttons :table="'projects'" :id="project.id"></table-buttons>
                    </td>
                </tr>
                </tbody>
            </table>
            <table-pagination :pagination="projects" :offset="4" @paginate="getProjects" @changePerPage="changePerPage">
            </table-pagination>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    export default {
        props: {
            projects: {}
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
            getProjects(page_number) {
                axios.get('/api/paginateProjects', {
                        params: {
                            page: page_number,
                            per_page: this.per_page
                        }
                    }
                )
                .then(response => {
                    this.projects = response.data;
                })
            },
            changePerPage(per_page) {
                this.per_page = per_page;
                this.getProducts(this.projects.current_page);
            },
        },
        created() {
        }
    }
</script>
