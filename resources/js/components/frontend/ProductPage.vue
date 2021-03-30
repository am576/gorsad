<template>
    <div class="row justify-content-center">
        <div class="col-6">
            <product-images :product="product"></product-images>
        </div>
        <div class="col-6">
            <div class="p-3" style="border: 1px solid #2a9055; height: 100% ">
                <h5 class="text-success">{{product.additional_info.family}}</h5>
                <h3>{{product.title}}</h3>
                <h5 class="text-muted">{{product.additional_info.common_name}}</h5>
                <div>----</div>
                <div>
                    {{product.description}}
                </div>
                <button class="btn btn-primary" @click="addToCart">Купить</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            product: {}
        },
        data() {
            return {
                current_image: ''
            }
        },
        methods: {
            setCurrentImage(image) {
                this.current_image = image;
            },
            addToCart() {
                axios.get('/cart/add', {
                    params: {
                        'product_id': this.product.id
                    }
                })
                .then(response => {
                    if(response.status == 200)
                    {
                        alert('Товар добавлен в корзину');
                    }
                    else
                    {
                        alert('Ошибка');
                    }
                })
            }
        },
        created() {
            this.setCurrentImage(this.product.images[0]);
            this.$set(this.product, 'additional_info', JSON.parse(this.product.additional_info));
        }
    }
</script>

<style lang="scss" scoped>
    .thumbs {
        .thumb-link {
            cursor: pointer;
            border: 1px solid #1b4b72;
        }
    }

    .preview {
        img {
            width: 100%;
        }
    }
</style>
