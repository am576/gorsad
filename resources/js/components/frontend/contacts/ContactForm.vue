<template>
    <div id="contact-form" class="row">
        <div id="form-col" class="col-6">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Имя</label>
                        <input type="text" class="form-control" v-model="message.name">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="message.email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Телефон</label>
                        <input type="text" class="form-control" v-model="message.phone">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Сообщение</label>
                        <textarea class="form-control" cols="30" rows="10" v-model="message.message"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div id="contacts-col" class="col-6"></div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                message: {},
                errors: {}
            }
        },
        methods: {
            sendMessage() {
                axios.post('/sendMessage', this.message)
                    .then(response => {
                        if(response.data.statusCode === 200) {
                            alert('OK')
                        }
                        else
                        {
                            if(Object.keys(response.data.errors).length){
                                this.errors = response.data.errors;
                            }
                        }
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>
    #contact-form {
        #form-col {
            background-color: #d9dfe1;
        }
        #contacts-col {
            background-color: #0b490f;
        }
    }
</style>
