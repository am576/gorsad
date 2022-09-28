<template>
    <form method="post" action="" @submit.prevent="submit">
        <button type="submit" class="btn btn-danger">
            <i class="mdi mdi-close mdi-18px"></i>
        </button>
    </form>
</template>

<script>
    export default {
        props: {
            query_id: 0
        },
        methods: {
            submit() {
                const zeroPad = (num, places) => String(num).padStart(places, '0')
                if(confirm('Отменить запрос ' + zeroPad(this.query_id,3) + '?')) {
                    axios.post('/admin/queries/' + this.query_id + '/cancel')
                        .then(response =>{
                            if(response.status === 200) {
                                window.location.reload()
                            }
                        }).catch(error => {
                        if (error.response.status === 422) {
                            alert(error.response.data);
                        }
                    })
                }
            }
        }
    }
</script>
