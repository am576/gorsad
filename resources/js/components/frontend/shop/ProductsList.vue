<template>
    <div class="row wr1">
        <div class="shop-nav">
            <div>
                <button class="nav-btn" id="btn-toggle-filters" @click="toggleFilters">
                    <i class="mdi mdi-24px" v-bind:class="filterShown ? 'mdi-chevron-up' : 'mdi-chevron-down'"></i>
                    {{filterBtnCaption}}
                </button>
            </div>
            <div v-if="isGuest">
                <button class="nav-btn" id="btn-login" @click="showSigninForm">
                    <i class="mdi mdi-login"></i>
                    Войти
                </button>
            </div>
            <div v-if="!isGuest">
                <b-dropdown id="account-dropdown" size="lg" right variant="link" block toggle-class="text-decoration-none" no-caret>
                    <template #button-content>
                        <div class="mdi mdi-account"></div>
                    </template>
                    <b-dropdown-text>
                        <div>{{user.name}}</div>
                        <a href="/profile" class="text-small">Личный кабинет</a>
                    </b-dropdown-text>
                    <b-dropdown-text>
                        <form ref="logout" id="logout-form" action="/logout" method="POST" style="display: none;">
                            <input type="hidden" name="_token" :value="csrf">
                        </form>
                        <a class="curpointer text-small" @click="logout">Выход </a>
                    </b-dropdown-text>
                </b-dropdown>
            </div>
        </div>
        <div class="row wr2">
            <div class="row wr3">
                <div v-for="product in products" style="width: 20%; padding: 10px">
                    <a :href="'/products/'+product.id">
                        <div class="product-card" v-bind:style="{'background-image':productThumbnail(product)}">
                            <span class="favorite mdi mdi-24px" v-bind:class="isProductFavorite(product.id)" @click.prevent="toggleProductFavorite(product.id)"></span>
                            <p class="description">{{product.title}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <signin-form ref="signinForm"></signin-form>
    </div>
</template>

<script>
    export default {
        props: {
            products: {
                type: Array
            },
            user: {
                type: Object
            }
        },
        data() {
            return {
                favorites: [],
                filterShown: true,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        methods: {
            toggleFilters() {
                this.filterShown = !this.filterShown;
                this.$emit('toggleFilters');
            },
            toggleProductFavorite(id) {
                axios.post('/favorite', {
                    product_id : id
                })
                .then(res => {
                    if(this.favorites.includes(id)) {
                        this.$delete(this.favorites, this.favorites.indexOf(id))
                    }
                    else {
                        this.favorites.push(id);
                    }
                })
            },
            getUserFavorites() {
                axios.get('/getfavorites')
                .then(res => {
                    this.favorites = res.data;
                })
            },
            isProductFavorite(id) {
                return {
                    'mdi-heart' : this.favorites.includes(id),
                    'mdi-heart-outline' : !this.favorites.includes(id),
                }
            },
            productThumbnail(product) {
                if(product.images.length) {
                    return `url(/storage/images/${product.images[0].medium})`
                }
                else {
                    return 'url(https://via.placeholder.com/150)'
                }
            },
            showSigninForm() {
                this.$refs.signinForm.showModal();
            },
            logout() {
                this.$refs.logout.submit()
            },
        },
        computed: {
            filterBtnCaption() {
                return this.filterShown ? 'Скрыть фильтры' : 'Показать фильтры';
            },
            isGuest() {
                return this.user == null;
            },
        },
        created() {
            this.getUserFavorites();
        }
    }
</script>
<style lang="scss">
    .product-card {
        position: relative;
    }
    .favorite {
        position: absolute;
        top: 5px;
        right: 5px;
    }
    .wr1 {
        justify-content: center;
        background-color: #343434;
        .shop-nav {
            padding: 10px 15px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white !important;

            .btn-link .mdi.mdi-account{
                font-size: 28px !important;
                color: #ffffff !important;
            }
        }
        .wr2 {
            width: 100%;
            justify-content: center;
            padding: 25px 0;
            background-color: #434242;
            .wr3 {
                padding: 5px;
                background-color: #403d3d;
            }
        }
    }
    button#account-dropdown__BV_toggle_.btn.dropdown-toggle.btn-link.btn-lg {
        padding: 0 !important;
    }
    .nav-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: none;
        border-radius: 3px;
        background-color: #4a4848;
        color: #ffffff;

        &:hover {
            background-color: #605b5b;
        }
    }
    #btn-toggle-filters {

        padding: 0 15px 0 5px;

        .mdi {
            margin-right: 5px;
        }
    }
    #btn-login {
        min-width: 100px;
        padding: 5px 15px 5px 10px;
    }
</style>
