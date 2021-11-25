<template>
    <div id="shop-navigation" class="row space-between m-0">
        <slot name="back_btn"></slot>
        <div class="text-light" v-if="isGuest">
            <a class="nav-link" @click="showSigninForm">Войти</a></div>
        <div v-if="!isGuest">
            <form ref="logout" id="logout-form" action="/logout" method="POST" style="display: none;">
                <input type="hidden" name="_token" :value="csrf">
            </form>
            <a class="nav-link" @click="logout">Выйти</a>
        </div>
        <signin-form ref="signinForm"></signin-form>
    </div>
</template>

<script>
    export default {
        props: {
            auth_user : {
                type: Object,
                default: null
            }
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
        },
        computed: {
            isGuest() {
                return this.auth_user == null;
            }
        }
    }
</script>
