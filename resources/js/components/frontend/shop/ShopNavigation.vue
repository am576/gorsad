<template>
    <div id="shop-navigation" class="row space-between m-0">
        <slot name="back_btn"></slot>
        <div class="text-light" v-if="isGuest">
            <a class="nav-link" @click="showSigninForm">Войти</a></div>
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
        <b-modal id="modal-cart" size="lg" title-html="<span class='mdi mdi-36px mdi-cart'></span> Корзина" hide-footer>
            <shopping-cart :cart_products="cart"></shopping-cart>
        </b-modal>
    </div>
</template>

<script>
    export default {
        props: {
            auth_user : {
                type: Object,
                default: null
            },
            cart: {}
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
                this.$bvModal.show('modal-cart');
            }
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
</style>
