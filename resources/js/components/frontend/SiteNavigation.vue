<template>
    <div>
        <div id="navigaton-mobile"  :class="{'open': showNav}">
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
            <i class="mdi mdi-close" @click="showNav = false"></i>
        </div>
        <nav class="navbar">
            <div id="navigation-icon-left" v-if="isMobileView">
                <i class="mdi mdi-menu mdi-36px" @click="showNav = true"></i>
            </div>

            <div class="mr-auto" v-if="!isMobileView"></div>
            <div id="mobile-logo" class="m-auto" v-if="isMobileView">Какое-то ЛоГо</div>
            <ul class="nav nav-pills ml-auto" v-if="!isMobileView">
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
            <div  class="ml-auto d-inline" v-if="!isMobileView">
                <input type="text" placeholder="Поиск">
            </div>
            <div id="navigation-icon-right" v-if="isMobileView">
                <i class="mdi mdi-dots-horizontal mdi-36px"></i>
            </div>
        </nav>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                isMobileView: false,
                showNav: false,
            }
        },
        methods: {
            handleView() {
                this.isMobileView = window.innerWidth <= 600;
            },
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

    #navigaton-mobile {
        $width : 300px;
        display: inline-block;
        position: absolute;
        top: 0;
        left: -300px;
        z-index: 10;
        transform: translateX(-$width);

        ul {
            float: left;
            display: inline-block;
            background: rgba(0,0,0,0.9);
            list-style: none;
            width: 200px;
            padding-left: 40px;
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

        &.open {
            transform: translateX($width);
            transition: 0.3s cubic-bezier(0,.12,.14,1) 0s;
        }

    }
</style>
