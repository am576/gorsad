<template>
    <div id="products-list" class="row">
        <section class="col-2">
            <h3>Фильтры</h3>
            <div v-for="attribute in attributes">
                <h5>{{attribute.name}}</h5>
                <div v-for="value in attribute.values">
                    <input type="checkbox">
                    <label>{{value.value}}</label>
                </div>
            </div>
            <button class="btn btn-primary">Применить</button>
        </section>
        <section class="col-10">
            <div class="row">
                <div class="product-link col-lg-4 col-md-3 text-center" v-for="product in products">
                    <product-bar :product="product"></product-bar>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
    export default {
        props: {
            products: {},
            attributes: {},
        },
        created() {
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

        .row {
            display: inline-flex;
            justify-content: center;
        }
    }
</style>
