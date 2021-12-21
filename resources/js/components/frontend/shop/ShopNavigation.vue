<template>
    <div id="shop-navigation" class="row space-between m-0">
        <slot name="back_btn"></slot>
        <div class="text-light" v-if="isGuest">
            <button class="nav-btn" id="btn-login" @click="showSigninForm">
                <i class="mdi mdi-login"></i>
                Войти
            </button>
        </div>
        <div class="d-flex align-items-center" v-if="!isGuest">
            <a class="nav-link curpointer" @click="showCart">
                <span class="mdi mdi-cart"></span>
            </a>
            <b-dropdown id="account-dropdown" size="lg" right variant="link" block toggle-class="text-decoration-none" no-caret>
                <template #button-content>
                    <div class="mdi mdi-account"></div>
                </template>
                <b-dropdown-text>
                    <div>{{auth_user.name}}</div>
                    <a href="/profile" class="text-small">Личный кабинет</a>
                </b-dropdown-text>
                <b-dropdown-text>
                    <form ref="logout" id="logout-form" action="/logout" method="POST" style="display: none;">
                        <input type="hidden" name="_token" :value="csrf">
                    </form>
                    <a class="curpointer text-small" @click="logout">Выход </a>
                </b-dropdown-text>
            </b-dropdown>
        </div>
        <signin-form ref="signinForm"></signin-form>
        <shopping-cart></shopping-cart>
    </div>
</template>

<script>
    export default {
        props: {
            auth_user : {
                type: Object,
                default: null
            },
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                sign_type: 'signin'
            }
        },
        methods: {
            showSigninForm() {
              this.$refs.signinForm.showModal();
            },
            logout() {
                this.$refs.logout.submit()
            },
            showCart() {
                this.$eventBus.$emit('showCart')
            },
        },
        computed: {
            isGuest() {
                return this.auth_user == null;
            }
        }
    }
</script>
<style lang="scss" scoped>
    .mdi {
        font-size: 28px !important;
        color: #ffffff !important;
    }
    #shop-navigation {
        #btn-login {
            min-width: 100px;
            padding: 0 10px;
        }
    }
</style>
