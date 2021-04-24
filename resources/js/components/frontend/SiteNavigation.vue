<template>
    <div>
        <nav class="navbar" style="margin-top: 40px;">
            <div id="navigation-icon-left" v-if="isMobileView">
                <i class="mdi mdi-menu mdi-36px" @click="toggleMobileNav()"></i>
            </div>
            <div id="mobile-logo" class="m-auto" v-if="isMobileView">Какое-то ЛоГо</div>
            <ul class="nav nav-pills m-auto" v-if="!isMobileView">
                <li class="nav-item">
                    <a href="/" class="nav-link">Главная</a>
                </li>
                <li class="nav-item">
                    <a href="/shop" class="nav-link">Каталог</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Страница_1</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Страница_2</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Страница_3</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Страница_4</a>
                </li>
            </ul>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" v-if="!isGuest" href="/cart">
                        <span class="mdi mdi-cart mdi-24px"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <div v-if="!isGuest">
                        <b-dropdown size="lg"  variant="link" toggle-class="text-decoration-none" no-caret>
                            <template #button-content>
                                <span class="mdi mdi-24px"
                                      v-bind:class="{'mdi-account':company_id === 0, 'mdi-briefcase':company_id !== 0}"
                                ></span>
                            </template>
                            <b-dropdown-text>
                                <div v-if="company_id === 0">{{auth_user.name}}</div>
                                <div v-if="company_id !== 0">{{user.companies[0].name}}</div>
                                <a href="/profile" class="text-small">Личный кабинет</a>
                            </b-dropdown-text>
                            <b-dropdown-item href="#">Ваши баллы</b-dropdown-item>
                            <b-dropdown-item href="/profile?tab=3">
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
                                <span class="mdi mdi-briefcase mdi-24px"></span>
                                {{user.companies[0].name}}
                            </b-dropdown-item>
                            <b-dropdown-item v-if="company_id !== 0" href="#" @click.prevent="logAsUser()">
                                <span class="mdi mdi-account mdi-24px"></span>
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
                    <a class="nav-link" href="/login">Вход</a>
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

    </div>

</template>

<script>
    export default {
        props: {
            auth_user: '',
            user: {}
        },
        data() {
            return {
                isMobileView: false,
                showNav: false,
                navOpen : false,
                showLinks: false,
                linksOpen: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                company_id: 0
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
                })
            },
            logAsUser() {
                axios.get('/logascompany'
                ).then(res => {
                    this.company_id = 0;
                })
            },
            checkActiveCompany() {
                this.user.companies.forEach((company) => {
                    if(company.is_active) {
                        this.company_id = company.id;
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

        },
        created() {
            this.handleView();
            this.checkActiveCompany();
            window.addEventListener('resize', this.handleView);
        }
    }
</script>

<style lang="scss" scoped>
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
