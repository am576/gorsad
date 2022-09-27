<template>
    <div class="table-buttons">
        <a :href="edit_url" title="Изменить" class="btn btn-rounded btn-sm btn-blue pull-right edit">
            <i class="mdi mdi-lead-pencil"></i> <span class="hidden-xs hidden-sm">Изменить</span>
        </a>
        <form class="table-delete-entity">
            <button @click="deleteRow()" type="button" title="Удалить" class="btn btn-rounded btn-sm btn-red pull-right delete hidden-xs hidden-sm"
                     value="Удалить">Удалить</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            table: '',
            id:    0,
        },
        methods: {
            deleteRow() {
                if (confirm('Вы уверены, что хотите удалить эту запись?'))
                {
                    let formData = new FormData();
                    formData.append('_method', 'DELETE');
                    axios.post(this.delete_url, formData)
                        .then(response => {
                            if(response.status == 200) {
                                window.location.reload()
                            }
                        })
                }
            }
        },
        computed: {
            edit_url() {
                return `${this.table}/${this.id}/edit`
            },
            delete_url() {
                return `${this.table}/${this.id}`
            }
        }
    }
</script>
