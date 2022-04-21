<template>
    <div class="dropdown">
        <button class="btn  d-flex" type="button" id="account-dropdown" data-toggle="dropdown">
            <div class="mdi mdi-account"></div>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
            <li>
                <div class="dropdown-text">
                    <div v-if="!userHasActiveCompany">{{user.name}}</div>
                    <div v-else>{{active_company.name}}</div>
                    <a href="/profile" class="text-small">Личный кабинет</a>
                </div>
            </li>
            <li>
                <a role="menuitem" href="#" target="_self">
                    <form ref="logout" id="logout-form" action="/logout" method="POST"
                          style="display: none;">
                        <input type="hidden" name="_token" :value="csrf">
                    </form>
                    <a class="dropdown-item d-flex align-items-center" @click="logout">
                                    <span class="mdi mdi-24px mdi-logout"
                                          style="color: rgb(22, 24, 27)!important;"></span>
                        <span class="ml-2">Выход</span>
                    </a>
                </a>
            </li>
            <li v-if="userHasCompanies">
                <hr class="dropdown-divider">
            </li>
            <li v-if="userHasCompanies" v-for="company in user.companies">
                <a class="dropdown-item d-flex justify-content-between align-items-center curpointer"
                   @click.prevent="logAsCompany(company)">
                    <span class="mdi mdi-briefcase" style="color: rgb(142,142,142)!important;"></span>
                    {{company.name}}
                </a>
            </li>
            <li v-if="userHasActiveCompany">
                <a class="dropdown-item d-flex justify-content-between align-items-center curpointer"
                   @click.prevent="logAsUser()">
                    <span class="mdi mdi-account" style="color: rgb(142,142,142)!important;"></span>
                    {{user.name}}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            user : {
                type: Object,
                default: null
            },
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                sign_type: 'signin',
                active_company: {}
            }
        },
        methods: {
            logAsCompany(company) {
                axios.get('/logascompany', {
                    params: {
                        company_id: company.id
                    }
                }).then(res => {
                    this.active_company = company;
                    // this.$eventBus.$emit('changeLoginType', 'company', this.company_id)
                })
            },
            logAsUser() {
                axios.get('/logasuser'
                ).then(res => {
                    this.active_company = {};
                    // this.$eventBus.$emit('changeLoginType', 'user')
                })
            },
            logout() {
                this.$refs.logout.submit()
            },
        },
        computed: {
            userHasCompanies() {
                return this.user.companies.length > 0;
            },
            userHasActiveCompany() {
                return Object.keys(this.active_company).length > 0;
            }
        },
        created() {
            this.active_company = this.user.company;
        }
    }
</script>
<style lang="scss" scoped>
    .mdi.mdi-account{
        font-size: 28px !important;
        color: #ffffff !important;
    }
</style>

