<template>
    <div class="site-nav">
        <div class="header-contacts">
            <div>
                <span class="mdi mdi-phone mdi-24px"></span>
                +7(4012) 52-21-11
            </div>
            <div>
                <span class="mdi mdi-email-open-outline mdi-24px"></span>
                info@group-zg.com
            </div>
            <div>
                <span class="mdi mdi-clock-time-four-outline mdi-24px"></span>
                Пн-Пт 9.00 - 18.00
            </div>
        </div>
        <nav class="navbar" style="background: rgba(0, 0, 0, 0.6)">
            <a href="/"><img src="/storage/images/public/logov2.png" alt=""></a>
            <div id="navigation-icon-left" v-if="isMobileView">
                <i class="mdi mdi-menu mdi-36px" @click="toggleMobileNav()"></i>
            </div>
            <div id="mobile-logo" class="m-auto" v-if="isMobileView">Какое-то ЛоГо</div>
            <ul class="nav nav-pills m-auto" v-if="!isMobileView">
                <li class="nav-item">
                    <a href="/shop" class="nav-link">Деревья</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Услуги</a>
                </li>
                <li class="nav-item">
                    <a href="/projects" class="nav-link">Проекты</a>
                </li>
                <li class="nav-item">
                    <a href="/knowhow" class="nav-link">Советы</a>
                </li>
                <li class="nav-item">
                    <a href="/styles" class="nav-link">Дизайн</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Контакты</a>
                </li>
            </ul>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href=""><span class="mdi mdi-magnify mdi-36px"></span></a>
                </li>
                <li class="nav-item"  v-if="!isGuest">
                    <a class="nav-link" href=""><span class="mdi mdi-heart-outline mdi-36px"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link curpointer" v-if="!isGuest"  @click="showCart">
                        <span class="mdi mdi-cart mdi-36px"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <div v-if="!isGuest">
                        <b-dropdown id="account-dropdown" size="lg" right variant="link" block toggle-class="text-decoration-none" no-caret>
                            <template #button-content>
                                <div class="mdi mdi-36px"
                                      v-bind:class="{'mdi-account':company_id === 0, 'mdi-briefcase':company_id !== 0}"
                                ></div>
                            </template>
                            <b-dropdown-text>
                                <div v-if="company_id === 0">{{auth_user.name}}</div>
                                <div v-if="company_id !== 0">{{user.companies[0].name}}</div>
                                <a href="/profile" class="text-small">Личный кабинет</a>
                            </b-dropdown-text>
                            <b-dropdown-item href="#">Ваши баллы</b-dropdown-item>
                            <b-dropdown-item href="/profile?tab=4">
                                Уведомления <span v-if="unreadNotificationsAmount" class="text-danger">{{unreadNotificationsAmount}}</span>
                            </b-dropdown-item>
                            <b-dropdown-item href="profile?tab=1">Мои запросы</b-dropdown-item>
                            <b-dropdown-item href="profile?tab=2">Мои заказы</b-dropdown-item>
<!--                            <b-dropdown-item href="#">Загрузить список растений</b-dropdown-item>-->
                            <b-dropdown-item href="#">
                                <form ref="logout" id="logout-form" action="/logout" method="POST" style="display: none;">
                                    <input type="hidden" name="_token" :value="csrf">
                                </form>
                                <a class="nav-link" @click="logout"> Выход </a>
                            </b-dropdown-item>
                            <b-dd-divider></b-dd-divider>
                            <b-dropdown-item v-if="company_id === 0" href="#" @click.prevent="logAsCompany(user.companies[0].id)">
                                <span class="mdi mdi-briefcase mdi-36px"></span>
                                {{user.companies[0].name}}
                            </b-dropdown-item>
                            <b-dropdown-item v-if="company_id !== 0" href="#" @click.prevent="logAsUser()">
                                <span class="mdi mdi-account mdi-36px"></span>
                                {{auth_user.name}}
                            </b-dropdown-item>
                            <b-dropdown-item href="#">
                                <div>
                                    <span class="mdi mdi-briefcase-plus mdi-24px"></span>
                                    <p class="d-inline-block">Добавить компанию</p>
                                </div>
                            </b-dropdown-item>
                        </b-dropdown>
                    </div>

                </li>

                <li class="nav-item" v-if="isGuest">
                    <b-dropdown id="login-dropdown" size="lg" right variant="link" block toggle-class="text-decoration-none" menu-class="login-dropdown" no-caret>
                        <template #button-content>
                            <div class="mdi mdi-36px mdi-account"></div>
                        </template>
                        <b-dropdown-form method="POST" action="/login" @submit.stop.prevent="doLogin">
                            <b-form-group label="Email" label-for="dropdown-form-email" >
                                <input type="hidden" name="_token" :value="csrf"></input>
                                <b-form-input
                                    id="dropdown-form-email"
                                    size="sm"
                                    placeholder=""
                                    v-model="loginCred.email"
                                    @focus="clearErrors"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="!hasEmailErrors">
                                    {{loginErrors.hasOwnProperty('email')?loginErrors.email[0]:''}}
                                </b-form-invalid-feedback>
                            </b-form-group>

                            <b-form-group label="Пароль" label-for="dropdown-form-password">
                                <b-form-input
                                    id="dropdown-form-password"
                                    type="password"
                                    size="sm"
                                    placeholder=""
                                    v-model="loginCred.password"
                                    @focus="clearErrors"
                                ></b-form-input>
                                <b-form-invalid-feedback :state="!hasPasswordErrors">
                                    {{loginErrors.hasOwnProperty('password')?loginErrors.password[0]:''}}
                                </b-form-invalid-feedback>
                                <b-form-invalid-feedback :state="!hasLoginErrors">
                                    {{loginErrors.hasOwnProperty('login')?loginErrors.login[0]:''}}
                                </b-form-invalid-feedback>
                                <b-form-text id="input-live-help"><a href="/recoverpassword">Забыли пароль?</a></b-form-text>
                            </b-form-group>

<!--                            <b-form-checkbox class="mb-3">Remember me</b-form-checkbox>-->
                            <b-button variant="primary" size="sm" type="submit">Войти</b-button>
                            <b-button variant="primary" size="sm" @click="goToRegisterPage">Регистрация</b-button>
                        </b-dropdown-form>
                    </b-dropdown>
                </li>
            </ul>
            <div id="navigation-icon-right" v-if="isMobileView">
                <i class="mdi mdi-dots-horizontal mdi-36px" @click="toggleMobileLinks"></i>
            </div>
        </nav>

        <div id="navigation-mobile" class="mobile-menu" :class="{'open': showNav}" v-if="isMobileView">
            <ul class="nav nav-pills ml-auto" >
                <li class="nav-item">
                    <a href="#" class="nav-link">Новинки</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Lalalala</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Babababa</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Nananana</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Mamamama</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Kakakaka</a>
                </li>
            </ul>
            <i class="mdi mdi-close" @click="toggleMobileNav" v-if="navOpen"></i>
        </div>

        <div id="links-mobile"  class="mobile-menu" :class="{'open': showLinks}">
            <i class="mdi mdi-close" @click="toggleMobileLinks" ></i>
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Корзина</a>
                </li>
                <li class="nav-item" v-if="isGuest">
                    <a class="nav-link" href="#">Войти</a>
                </li>
            </ul>
        </div>
        <shopping-cart></shopping-cart>
    </div>

</template>

<script>
    export default {
        props: {
            auth_user: '',
            user: {},
        },
        data() {
            return {
                isMobileView: false,
                showNav: false,
                navOpen : false,
                showLinks: false,
                linksOpen: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                company_id: 0,
                loginCred: {
                    email: '',
                    password: ''
                },
                emailerror: '',
                loginErrors: {
                    email: [],
                    password: [],
                    login: []
                },

            }
        },
        methods: {
            handleView() {
                this.isMobileView = window.innerWidth <= 600;
            },
            toggleMobileNav() {
                this.showNav = !this.showNav;
                this.navOpen = !this.navOpen;
            },
            toggleMobileLinks() {
                this.showLinks = !this.showLinks;
                this.linksOpen = !this.linksOpen;
            },
            goToRegisterPage() {
                window.location.href = '/register';
            },
            logout() {
                this.$refs.logout.submit()
            },
            logAsCompany(company_id) {
                axios.get('/logascompany', {
                    params: {
                        company_id: company_id
                    }
                }).then(res => {
                    this.company_id = company_id;
                    this.$eventBus.$emit('changeLoginType', 'company', this.company_id)
                })
            },
            logAsUser() {
                axios.get('/logasuser'
                ).then(res => {
                    this.company_id = 0;
                    this.$eventBus.$emit('changeLoginType', 'user')
                })
            },
            checkActiveCompany() {
                this.user.companies.forEach((company) => {
                    if(company.is_active) {
                        this.company_id = company.id;
                    }
                })
            },
            doLogin() {
                axios.post('/login', this.loginCred)
                    .then(response => {
                        if(response.data.statusCode === 200) {
                            window.location.reload();
                        }
                        else
                        {
                            if(Object.keys(response.data.errors).length){
                                this.loginErrors = response.data.errors;
                            }
                        }
                    })
            },
            clearErrors() {
                Object.keys(this.loginErrors).forEach(key => {
                    while(this.loginErrors[key].length > 0)
                    this.loginErrors[key].pop();
                })
            },
            showCart() {
                this.$eventBus.$emit('showCart')
            }
        },
        computed: {
            isGuest() {
                return this.auth_user == null;
            },
            unreadNotificationsAmount() {
                let amount = 0;
                this.user.user_notifications.forEach(notification => {
                    if(notification.status === 'unread')
                        amount++;
                })

                return amount;
            },
            hasEmailErrors() {
                if (this.loginErrors.hasOwnProperty('email'))
                {
                    return this.loginErrors.email.length > 0
                }
                    return false;
            },
            hasPasswordErrors() {
                if (this.loginErrors.hasOwnProperty('password'))
                {
                    return this.loginErrors.password.length > 0
                }
                return false;
            },
            hasLoginErrors() {
                if (this.loginErrors.hasOwnProperty('login'))
                {
                    return this.loginErrors.login.length > 0
                }
                return false;

            }
        },
        created() {
            this.handleView();
            // this.checkActiveCompany();
            window.addEventListener('resize', this.handleView);
        }
    }
</script>

<style lang="scss">
    .site-nav {
        /*position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1;*/

        & a.nav-link, .btn-link .mdi, .mdi {
            color: #fff !important;
            text-transform: uppercase;
            font-weight: 800;
        }

        img {
            height: 70px;
        }
    }
</style>
<style lang="scss" scoped>
    .header-contacts {
        display: flex;
        padding: 15px 0 15px 15%;
        background: rgba(0, 0, 0, 0.8);
        color: #dfdfdf;

        .mdi {
            color: #83b950 !important;
            margin-right: 5px;
        }

        div {
            display: flex;
            align-items: center;
            margin-right: 50px;
            font-size: 14px;
        }
    }
    #mobile-logo {
        font-size: 2rem;
    }

    i {
        cursor: pointer;
    }

    $menu_width : 300px;

    #navigation-mobile {
        left: -$menu_width;
        ul {
            float: left;
        }

        &.open {
            transform: translateX($menu_width);
            transition: 0.3s cubic-bezier(0,.12,.14,1) 0s;
        }
    }

    #links-mobile {
        right: -$menu_width;
        text-align: right;

        ul {
            float: right;
            text-align: left;
        }

        &.open {
            transform: translateX(-1 * $menu_width);
            transition: 0.3s cubic-bezier(0,.12,.14,1) 0s;
        }

        input {
            width: $menu_width * 0.7;
            box-sizing: border-box;
        }
    }

    .mobile-menu {
        min-width: $menu_width;
        display: inline-block;
        position: fixed;
        top: 0;
        z-index: 10;

        ul {
            display: inline-block;
            background: rgba(0,0,0,0.9);
            list-style: none;
            padding: 0 2rem;
            li {
                color: #fff;
                font-size: 2rem;
                font-weight: bold;
                margin-bottom: 20px;
                cursor: pointer;
                &:hover {
                    color: #111;
                }
            }
        }

        i {
            font-size: 2rem;
        }
    }
</style>
