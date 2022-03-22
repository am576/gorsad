<template>
    <div class="site-nav">
        <div class="header-contacts" v-if="!isMobileView">
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
        <nav id="header-navbar" class="navbar">
            <a href="/">
                <img src="/storage/images/public/logov2.png" alt="" v-if="!isMobileView">
                <img src="/storage/images/public/logov2m.png" alt="" v-if="isMobileView">
            </a>
            <ul class="nav nav-pills m-auto" v-if="!isMobileView">
                <li class="nav-item menu-link" :class="{selected: isSelected ==='shop'}" @mouseenter.stop="menuHover(1)" @mouseleave.stop="unHover">
                    <span :class="{hovered : isHovered ===(1)}"></span>
                    <a href="/shop" class="nav-link">Деревья</a>
                </li>
                <li class="nav-item menu-link" ref="services" :class="{selected: isSelected ==='services'}" @mouseenter.stop="menuHover(2)" @mouseleave.stop="unHover">
                    <span :class="{hovered : isHovered === (2)}"></span>
                    <a href="/services" class="nav-link">Услуги</a>
                </li>
                <li class="nav-item menu-link" ref="projects" :class="{selected: isSelected ==='projects'}" @mouseenter.stop="menuHover(3)" @mouseleave.stop="unHover">
                    <span :class="{hovered : isHovered === (3)}"></span>
                    <a href="/projects" class="nav-link">Проекты</a>
                </li>
                <li class="nav-item menu-link" @mouseenter.stop="menuHover(4)" @mouseleave.stop="unHover">
                    <span :class="{hovered : isHovered === (4)}"></span>
                    <a href="/knowhow" class="nav-link">Советы</a>
                </li>
                <li class="nav-item menu-link" ref="styles" :class="{selected: isSelected ==='styles'}" @mouseenter.stop="menuHover(5)" @mouseleave.stop="unHover">
                    <span :class="{hovered : isHovered === (5)}"></span>
                    <a href="/styles" class="nav-link">Дизайн</a>
                </li>
                <li class="nav-item menu-link" ref="contacts" :class="{selected: isSelected ==='contacts'}" @mouseenter.stop="menuHover(6)" @mouseleave.stop="unHover">
                    <span :class="{hovered : isHovered ===(6)}"></span>
                    <a href="#" class="nav-link">Контакты</a>
                </li>
            </ul>
            <ul class="nav nav-pills" v-if="isMobileView">
                <li id="navigation-icon-search" v-if="isMobileView">
                    <i class="mdi mdi-magnify mdi-36px" @click="toggleMSearchInput()" v-show="!showMSearchInput"></i>
                    <input ref="msearch_input" class="form-control" v-model="search_product_name" placeholder="Искать по названию"
                           type="text" @keyup.enter="submit" v-show="showMSearchInput" @blur="showMSearchInput = false">
                </li>
                <li id="navigation-icon-right" v-if="isMobileView">
                    <i class="mdi mdi-menu" @click="toggleMobileNav()"></i>
                </li>
            </ul>
            <ul class="nav nav-pills" v-if="!isMobileView">
                <li class="nav-item">
                    <a class="nav-link curpointer"><span class="mdi mdi-magnify mdi-36px" @click="toggleSearchInput()" v-show="!showSearchInput"></span></a>
                    <input ref="search_input" class="form-control" v-model="search_product_name" placeholder="Искать по названию"
                           type="text" @keyup.enter="submit" v-show="showSearchInput" @blur="showSearchInput = false">
                </li>
                <li class="nav-item"  v-if="!isGuest">
                    <a class="nav-link" href="/profile?tab=2"><span class="mdi mdi-heart-outline mdi-36px"></span></a>
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
                            <b-dropdown-item v-if="hasCompanies && company_id === 0" href="#" @click.prevent="logAsCompany(user.companies[0].id)">
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
            <form action="/search" method="post" style="display: none">
                <input type="hidden" name="_token" :value="csrf">
                <input name="product_name" type="hidden" v-model="search_product_name">
                <button ref="submitButton" type="submit" class="btn search-btn hidden" ></button>
            </form>
        </nav>
        <div id="navigation-mobile"  :class="{'open': showNav}"  v-if="isMobileView">
            <div class="menu-inner" :style="{'width': device.width + 'px', height: device.height + 'px'}" v-show="showNav">
                <a href="/shop">Каталог растений</a>
                <a href="/services">Услуги</a>
                <a href="/projects/all">Проекты</a>
                <a href="/shop">Советы</a>
                <a href="/styles">Дизайн</a>
                <a href="/contacts">Контакты</a>
            </div>
            <i class="mdi mdi-close" @click="toggleMobileNav" v-if="navOpen"></i>
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
                isHovered: 0,
                isSelected: '',
                showLinks: false,
                linksOpen: false,
                showSearchInput: false,
                showMSearchInput: false,
                search_product_name : '',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                company_id: 0,
                loginCred: {
                    email: '',
                    password: ''
                },
                refs: {},
                emailerror: '',
                loginErrors: {
                    email: [],
                    password: [],
                    login: []
                },
                device: {}

            }
        },
        methods: {
            handleView() {
                this.isMobileView = window.innerWidth <= 600;
                this.width = $(window).width();
                this.device = {
                    width: $(window).width(),
                    height: $(window).height()
                }
            },
            toggleMobileNav() {
                this.showNav = !this.showNav;
                this.navOpen = !this.navOpen;
                this.handleView();
                let b = document.getElementsByTagName('html');
                b[0].className += 'stop-scrolling';
            },
            toggleMobileLinks() {
                this.showLinks = !this.showLinks;
                this.linksOpen = !this.linksOpen;
            },
            toggleSearchInput() {
                this.showSearchInput = true;
                this.$nextTick(() => {
                    this.$refs.search_input.focus();
                })
            },
            toggleMSearchInput() {
                this.showMSearchInput = true;
                this.$nextTick(() => {
                    this.$refs.msearch_input.focus();
                })

            },
            submit() {
                this.$refs.submitButton.click();
            },
            menuHover(e) {
                this.isHovered = e;
            },
            unHover() {
                this.isHovered = 0;
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
            },
            setSelectedItem() {
                let items = ['services', 'projects', 'styles', 'contacts'];
                items.forEach(item => {
                    if(window.location.href.includes(item)) {
                        this.isSelected = item;
                    }
                })
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
            },
            hasCompanies() {
                return this.user.companies.length > 0
            }
        },
        created() {
            this.handleView();
            // this.checkActiveCompany();
            window.addEventListener('resize', this.handleView);
            document.body.addEventListener('touchmove', function(e){
                document.getElementsByTagName('html')[0]. style .height = "100vh !important";
                document.getElementsByTagName('html')[0]. style. overflow = "hidden !important";
            });
        },
        mounted() {
            this.$nextTick(()=>{
                this.setSelectedItem();
                this.handleView();
            });
        }
    }
</script>

<style lang="scss">
    .site-nav {
        @media (max-width: 590px) {
            position: fixed;
            width: 100%;
            z-index: 100;
        }
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
    #header-navbar {
        @media (min-width: 591px) {
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;

        }
        @media (max-width:590px) {
            background-color: #ffffff;
            padding: 0 0 0 10px;
        }
    }
    .nav-item.menu-link {
        border-bottom: 3px solid transparent;
        position: relative;
        &.selected {
            border-bottom: 3px solid #8cc556;
        }
        span {
            position: absolute;
            box-sizing: content-box;
            top: 0;
            opacity: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            display: block;
            border-bottom: 3px solid transparent;
            border-bottom: 3px solid #8cc556;
            pointer-events: none;
        }
        span.hovered {
            animation: slidein 0.25s;
            -webkit-animation-fill-mode: forwards; /* Safari 4.0 - 8.0 */
            animation-fill-mode: forwards;

            @keyframes slidein {
                from {
                    left: -100%;
                    opacity: 0;
                }

                to {
                    left: 0;
                    opacity: 100;
                }
            }
        }

    }
    #mobile-logo {
        font-size: 2rem;
    }

    i {
        cursor: pointer;
    }
    #navigation-icon-search {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 10px;
        i {
            color: #000000 !important;
        }
        @media (max-width:590px) {
            width: 40vw;
        }
    }
    #navigation-icon-right {
        background-color: #0b2d1b !important;
        height: 70px;
        padding: 0 10px;
        font-size: 43px;
        i {
            font-size: 40px;
        }
    }

    $menu_width : 300px;

    #navigation-mobile {
        background-color: #ffffff;
        position: fixed;
        left: 0;
        top: 70px;
        z-index: 9999;
        .menu-inner {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-top: 15vh;
            align-items: center;
            a {
                display:block;
                padding-bottom: 3vh;
                text-transform: uppercase;
                color: #000000;
                font-size: 4vh;
                font-weight: 600;
                &:hover {
                    text-decoration: none;
                }
            }
        }

        &.open {
            /*transform: translateX($menu_width);
            transition: 0.3s cubic-bezier(0,.12,.14,1) 0s;*/
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
    .stop-scrolling {
        height: 100% !important;
        overflow: hidden !important;
    }

</style>
