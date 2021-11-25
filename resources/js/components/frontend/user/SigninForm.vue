<template>
    <b-modal :id="modal_id" centered hide-footer>
        <template #modal-title>
            {{sign_type.form_title}}
        </template>
        <form method="POST" :action="sign_type.action">
            <input type="hidden" name="_token" :value="csrf">
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email"  required autocomplete="email" autofocus>
                    <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                </div>
            </div>

            <div class="form-group row" v-if="isRegisterForm">
                <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>

                    <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                    <span class="invalid-feedback" role="alert">
                        <strong></strong>
                    </span>
                </div>
            </div>

            <div class="form-group row" v-if="isRegisterForm">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтверждение пароля</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row mb-0" v-if="!isRegisterForm">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Войти
                    </button>
                    <a class="btn btn-link" @click="sign_type = sign_types.register">
                        Регистрация
                    </a>
                </div>
            </div>

            <div class="form-group row mb-0" v-if="isRegisterForm">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Зарегистрироваться
                    </button>
                    <a class="btn btn-link" @click="sign_type = sign_types.login">
                        Вход
                    </a>
                </div>
            </div>
        </form>
    </b-modal>
</template>

<script>
    export default {
        props: {
            modal_id: {
                type: String,
                default: 'modal-login'
            }
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                sign_types:
                {
                    login : {
                        action: '/login',
                        form_title: 'Вход'
                    },
                    register : {
                        action: '/register',
                        form_title: 'Регистрация'
                    }
                },
                sign_type: {}
            }
        },
        methods: {
            showModal() {
                this.$bvModal.show(this.modal_id);
            }
        },
        computed: {
            isRegisterForm() {
                return this.sign_type === this.sign_types.register;
            }
        },
        created() {
            this.sign_type = this.sign_types.login
        }
    }
</script>
