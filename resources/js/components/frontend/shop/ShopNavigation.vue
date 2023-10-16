<template>
    <div id="shop-navigation" class="shop-nav row space-between m-0">
        <slot name="back_btn"></slot>
        <div class="d-flex" v-if="!isMobileView">
            <slot name="additional_buttons"></slot>
            <div class="text-light" v-if="isUserEnabled && isGuest">
                <button class="nav-btn" id="btn-login" @click="showSigninForm">
                    <i class="mdi mdi-login"></i>
                    Войти
                </button>
            </div>
            <div class="d-flex align-items-center" v-if="!isGuest">
                <a class="nav-link curpointer" @click="showCart">
                    <span class="mdi mdi-cart"></span>
                </a>
               <account-dropdown :user="user" v-if="isUserEnabled"></account-dropdown>
            </div>
        </div>
       <signin-form ref="signinForm" v-if="isUserEnabled"></signin-form>

    </div>
</template>

<script>
    export default {
        props: {
            user : {
                type: Object,
                default: null
            },
            isMobileView: false
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                sign_type: 'signin',
                isUserEnabled: false,
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
            isUserModuleEnabled() {
                axios.get('/api/isFeatureEnabled/' + 'user_module', {
                })
                .then(res => {
                    this.isUserEnabled = res.data;
                })
            },

        },
        computed: {
            isGuest() {
                return this.user == null;
            },

        },
        created() {
            this.isUserModuleEnabled();
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
    .shop-nav {
        background: #343434;
        padding: 10px 15px;
        align-items: center;

        button#account-dropdown__BV_toggle_.btn.dropdown-toggle.btn-link.btn-lg {
            padding: 0 !important;
        }
    }
</style>
