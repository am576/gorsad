<template>
    <div id="products-list" class="row">
        <section class="col-2">
            Фильтры
        </section>
        <section class="col-10">
            <div class="row">
                <div class="col-lg-4 col-md-3" v-for="product in products">
                    <a href="#">
                        <img :src="'/storage/images/' + product.images[0].medium" alt="">
                    </a>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
    export default {
        props: {
            products: {}
        }
    }
</script>

<style lang="scss" scoped>
    #products-list {
        section
        {
            border: 1px solid;

            img {

            }
        }
    }
</style>
