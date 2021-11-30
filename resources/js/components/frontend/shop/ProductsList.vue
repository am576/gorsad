<template>
    <div class="row wr1">
        <div class="shop-nav">
            <div>
                <button class="nav-btn" id="btn-toggle-filters" @click="toggleFilters">
                    <i class="mdi mdi-24px" v-bind:class="filterShown ? 'mdi-chevron-up' : 'mdi-chevron-down'"></i>
                    {{filterBtnCaption}}
                </button>
            </div>
            <div>
                <button class="nav-btn" id="btn-login" @click="showSigninForm">
                    <i class="mdi mdi-login mdi-24px"></i>
                    Войти
                </button>
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
        },
        data() {
            return {
                favorites: [],
                filterShown: true,
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
        },
        computed: {
            filterBtnCaption() {
                return this.filterShown ? 'Скрыть фильтры' : 'Показать фильтры';
            }
        },
        created() {
            this.getUserFavorites();
        }
    }
</script>
<style lang="scss" scoped>
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
            padding: 15px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            color: white !important;
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
        padding-left: 10px;
        padding-right: 15px;
    }
</style>
