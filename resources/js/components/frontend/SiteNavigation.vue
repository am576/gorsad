<template>
    <div class="site-nav">
        <div class="header-contacts" v-if="!isMobileView">
            <a href="/" class="logo-link" v-if="isBreakPoint890">
                <img src="/storage/images/public/logov2.png" alt="" v-if="!isMobileView">
            </a>
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
            <a href="/" class="logo-link" v-if="!isBreakPoint890 || isMobileView">
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
                <li class="nav-item menu-link" :class="{selected: isSelected ==='knowhow'}" @mouseenter.stop="menuHover(4)" @mouseleave.stop="unHover">
                    <span :class="{hovered : isHovered === (4)}"></span>
                    <a href="/knowhow" class="nav-link">Советы</a>
                </li>
                <li class="nav-item menu-link" ref="styles" :class="{selected: isSelected ==='design'}" @mouseenter.stop="menuHover(5)" @mouseleave.stop="unHover">
                    <span :class="{hovered : isHovered === (5)}"></span>
                    <a href="/design" class="nav-link">Дизайн</a>
                </li>
                <li class="nav-item menu-link" ref="contacts" :class="{selected: isSelected ==='contacts'}" @mouseenter.stop="menuHover(6)" @mouseleave.stop="unHover">
                    <span :class="{hovered : isHovered ===(6)}"></span>
                    <a href="/contacts" class="nav-link">Контакты</a>
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

                <!--<li class="nav-item">
                    <div v-if="!isGuest">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="account-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="mdi mdi-36px mdi-account"></div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li>
                                    <div class="dropdown-text">
                                        <div v-if="company_id === 0">{{user.name}}</div>
                                        <div v-else>{{user.companies[0].name}}</div>
                                        <a href="/profile?tab=user_cabinet" class="text-small">Личный кабинет</a>
                                    </div>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item">Мои баллы</a>
                                </li>
                                <li>
                                    <a href="/profile?tab=notifications" class="dropdown-item">
                                        Уведомления <span v-if="unreadNotificationsAmount" class="text-danger">{{unreadNotificationsAmount}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="profile?tab=queries" class="dropdown-item">Мои запросы</a>
                                </li>
                                <li>
                                    <a href="profile?tab=orders" class="dropdown-item">Мои заказы</a>
                                </li>
                                <li>
                                    <a role="menuitem" href="#" target="_self">
                                        <form ref="logout" id="logout-form" action="/logout" method="POST" style="display: none;">
                                            <input type="hidden" name="_token" :value="csrf">
                                        </form>
                                        <a class="dropdown-item d-flex align-items-center" @click="logout">
                                            <span class="mdi mdi-24px mdi-logout" style="color: rgb(22, 24, 27)!important;"></span>
                                            <span class="ml-2">Выход</span>
                                        </a>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>-->
                <!--<li class="nav-item" v-if="isGuest">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="login-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="mdi mdi-36px mdi-account"></div>
                        </button>
                        <div class="login-dropdown dropdown-menu dropdown-menu-right" aria-labelledby="dropdownAll">
                            <form id="login-dropdown-form" action="/login" method="POST" @submit.stop.prevent="doLogin">
                                <div class="form-group">
                                    <label class="d-block" for="dropdown-form-email">Email</label>
                                    <div>
                                        <input type="hidden" name="_token" :value="csrf">
                                        <input class="form-control form-control-sm" type="text" id="dropdown-form-email"
                                               placeholder=""
                                               v-model="loginCred.email"
                                               @focus="clearErrors"
                                        >
                                        <small class="text-danger" v-show="hasEmailErrors">
                                            {{loginErrors.hasOwnProperty('email')?loginErrors.email[0]:''}}
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dropdown-form-password">Пароль</label>
                                    <div>
                                        <input class="form-control form-control-sm" id="dropdown-form-password" type="password" v-model="loginCred.password" @focus="clearErrors">
                                        <small class="text-danger" v-show="hasPasswordErrors">
                                            {{loginErrors.hasOwnProperty('password')?loginErrors.password[0]:''}}
                                        </small>
                                        <small class="text-danger" v-show="hasLoginErrors">
                                            {{loginErrors.hasOwnProperty('login')?loginErrors.login[0]:''}}
                                        </small>
                                        <small id="input-live-help" class="form-text text-muted">
                                            <a href="/recoverpassword"><small>Забыли пароль?</small></a>
                                        </small>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Войти</button>
                                <button class="btn btn-primary" type="button" @click="goToRegisterPage">Регистрация</button>
                            </form>
                        </div>
                    </div>
                </li>-->
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
                <a href="/projects">Проекты</a>
                <a href="/knowhow">Советы</a>
                <a href="/design">Дизайн</a>
                <a href="/contacts">Контакты</a>
            </div>
            <i class="mdi mdi-close" @click="toggleMobileNav" v-if="navOpen"></i>
        </div>
<!--        <shopping-cart></shopping-cart>-->
    </div>

</template>

<script>
    export default {
        props: {
            user: {},
        },
        data() {
            return {
                isMobileView: false,
                isBreakPoint890: false,
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
                this.isBreakPoint890 = window.innerWidth <= 890;
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
                let items = ['services', 'projects', 'knowhow', 'design', 'contacts'];
                items.forEach(item => {
                    if(window.location.href.includes(item)) {
                        this.isSelected = item;
                    }
                })
            }
        },
        computed: {
            isGuest() {
                return this.user == null;
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
        @media (max-width: 600px) {
            position: fixed;
            width: 100%;
            z-index: 1000;
        }

        & a.nav-link, .btn-link .mdi, .mdi {
            @media (min-width: 870px) {
                font-weight: 800;
            }
            color: #fff !important;
            text-transform: uppercase;
            font-weight: normal;
        }
        & .logo-link {
            @media (min-width: 600px) {
                /*margin: auto;*/
            }
        }
        img {
            @media (min-width: 360px) {
                height: 8vh;
            }
            @media (min-width: 768px) {
                height: 70px;
            }

        }
    }
</style>
<style lang="scss" scoped>
    .header-contacts {
        display: flex;

        padding: 15px 0 15px 0;
        background: rgba(0, 0, 0, 0.8);
        color: #dfdfdf;

        @media(min-width: 600px) {
            justify-content: flex-end;
            gap: 20px;
            padding-right: 30px;
        }
        @media(min-width: 870px) {
            justify-content: space-evenly;
        }
        @media(min-width: 1200px) {
            justify-content: center;
            gap: 30px;
        }
        .mdi {
            color: #83b950 !important;
            margin-right: 5px;
        }

        div {
            display: flex;
            align-items: center;
            font-size: 14px;
            @media(min-width: 600px) {
                max-width: 30%;
                font-size: 12px;
            }
        }
    }
    #header-navbar {
        z-index: 1000;
        @media (min-width: 600px) {
            background: rgba(0, 0, 0, 0.6);
            padding: 9px;
            font-weight: normal;
        }
        @media (max-width:600px) {
            background-color: #ffffff;
            padding: 0 0 0 10px;
            border-bottom: 1px solid #b6b9bd;
        }
        @media (min-width:870px) {
            font-weight: 800;
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
        @media (max-width:600px) {
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
    #login-dropdown-form {
        display: inline-block;
        padding: 0.25rem 1.5rem;
        width: 100%;
        clear: both;
        font-weight: 400;
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

    .dropdown-toggle:after { content: none }

</style>
