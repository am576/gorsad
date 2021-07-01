<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-1">
                <a href="/"><img src="storage/images/logo/shop-logo.png" alt=""></a>
            </div>
            <div class="col-md-10">
                <div class="pt-3">
                    <shop-filter :attributes_groups="attributes"></shop-filter>
                    <products-list :products="products"></products-list>
                </div>
            </div>
            <div class="col-1"></div>

        </div>
    </div>
</template>

<script>
    export default {
        props: {
            products: {
                type: Array
            },
            attributes: {
                type: Array,

            }
        }
    }
</script>
