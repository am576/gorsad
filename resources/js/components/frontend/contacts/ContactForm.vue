<template>
    <div id="contact-form" class="row">
        <div id="contacts-col" class="col-6">
            <h3>Наши контакты</h3>
            <div class="contacts-list">
                <div>
                    <i class="mdi mdi-36px mdi-map-marker-outline"></i>
                    <span>г.Калининград, ул. Еловая аллея, д.26</span>
                </div>
                <div>
                    <i class="mdi mdi-36px mdi-email-open-outline"></i>
                    <span>mail@gorsad39.ru</span>
                </div>
                <div>
                    <i class="mdi mdi-36px mdi-phone-classic"></i>
                    <span>+7 (4012) 71-95-11</span>
                </div>
                <div>
                    <i class="mdi mdi-36px mdi-phone-classic"></i>
                    <span>+7 (4012) 52-22-11</span>
                </div>
            </div>
        </div>
        <div id="form-col" class="col-6">
            <div class="row">
                <div class="form-group">
                    <label>Имя</label>
                    <input type="text" class="form-control" v-model="message.name" @focus="clearErrors">
                    <small class="text-danger">
                        {{errors.hasOwnProperty('name')?errors.name[0]:''}}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" v-model="message.email" @focus="clearErrors">
                    <small class="text-danger">
                        {{errors.hasOwnProperty('email')?errors.email[0]:''}}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label>Телефон</label>
                    <input type="text" class="form-control" v-model="message.phone" @focus="clearErrors">
                    <small class="text-danger">
                        {{errors.hasOwnProperty('phone')?errors.phone[0]:''}}
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label>Сообщение</label>
                    <textarea class="form-control" rows="5" v-model="message.message" @focus="clearErrors"></textarea>
                    <small class="text-danger">
                        {{errors.hasOwnProperty('message')?errors.message[0]:''}}
                    </small>
                </div>
            </div>
            <div class="row mt-3">
                <div class="form-group">
                    <input type="button" class="btn btn-lg btn-success btn-block form-control" value="ОТПРАВИТЬ" @click="sendMessage">
                </div>
            </div>
        </div>
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
                        if(response.status === 200) {
                            alert('Спасибо за обращение! В ближайшее время с вами свяжется наш менеджер.');
                            window.location.href = '/';
                        }
                    }).catch(error => {
                        if(error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        }
                })
            },
            clearErrors() {
                this.errors = {};
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "resources/sass/variables";
    #contact-form {
        margin-top: -$contacts-header-margin;
        margin-bottom: 100px;
        -webkit-box-shadow: 0px 0px 7px 3px rgba(0,0,0,0.52);
        -moz-box-shadow: 0px 0px 7px 3px rgba(0,0,0,0.52);
        box-shadow: 0px 0px 7px 3px rgba(0,0,0,0.52);
        #form-col {
            padding-top: 30px;
            padding-bottom: 20px;
            background-color: #fff;
            .row {
                justify-content: center;
            }
        }
        #contacts-col {
            background-color: #20a353;
            color: #fff;
            padding: 30px 50px;
            div {
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 20px;
            }
            span {
                font-size: 20px;
            }
            .contacts-list {
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: space-evenly;
            }
        }
    }
</style>
