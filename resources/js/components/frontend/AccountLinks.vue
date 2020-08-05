<template>

<!--  mobile template  -->
<!--  end mobile template  -->

<!--  desktop template  -->
    <nav class="navbar">
        <ul class="nav nav-pills ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Желаемое</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Корзина</a>
            </li>
            <li class="nav-item" v-if="isGuest">
                <a class="nav-link" href="#">Войти</a>
            </li>
        </ul>
    </nav>
<!--  end desktop template  -->
</template>

<script>
    export default {
        props: ['auth_user'],
        data() {
            return {
                isMobileView: false,
                showMenu: false,
                menuOpen : false
            }
        },
        methods: {
            handleView() {
                this.isMobileView = window.innerWidth <= 600;
            },
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
