<template>
    <div>
        <nav class="navbar" v-if="!isMobileView">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <a class="nav-link" v-if="!isGuest" href="/cart">Корзина</a>
                </li>
                <li class="nav-item">
                    <form ref="logout" id="logout-form" action="/logout" method="POST" style="display: none;">
                        <input type="hidden" name="_token" :value="csrf">
                    </form>
                    <a class="nav-link" v-if="!isGuest" @click="logout"> Выход </a>
                </li>
                <li class="nav-item" v-if="isGuest">
                    <a class="nav-link" href="/login">Выход</a>
                </li>
            </ul>
        </nav>
        <nav class="navbar">
            <div id="navigation-icon-left" v-if="isMobileView">
                <i class="mdi mdi-menu mdi-36px" @click="toggleMobileNav()"></i>
            </div>
            <div id="mobile-logo" class="m-auto" v-if="isMobileView">Какое-то ЛоГо</div>
            <ul class="nav nav-pills m-auto" v-if="!isMobileView">
                <li class="nav-item">
                    <a href="#" class="nav-link">Новинки</a>
                </li>
                <li class="nav-item">
                    <a href="shop" class="nav-link">Каталог</a>
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
            auth_user: ''
        },
        data() {
            return {
                isMobileView: false,
                showNav: false,
                navOpen : false,
                showLinks: false,
                linksOpen: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
            }
        },
        computed: {
            isGuest() {
                return this.auth_user == null;
            }
        },
        created() {
            this.handleView();
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
