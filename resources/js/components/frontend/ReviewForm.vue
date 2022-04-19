<template>
    <g-modal :modal_class="'review-modal'" ref="reviewModal">
        <template v-slot:header>
            <header class="modal-header mb-3">Ваше мнение о {{product.title}}</header>
        </template>
        <input class="form-control" type="text" v-model="review.pluses" placeholder="Достоинства">
        <input class="form-control" type="text" v-model="review.minuses" placeholder="Недостатки">
        <input class="form-control" type="text" v-model="review.comment" placeholder="Комментарий">
        <template v-slot:footer>
            <footer class="modal-footer justify-content-center">
                <button class="btn btn-primary btn-lg" @click="postReview()">Сохранить</button>
            </footer>
        </template>
    </g-modal>
</template>

<script>
    export default {
        props: {
            product: {
                type: Object
            }
        },
        data() {
            return {
                review: {}
            }
        },
        methods: {
            showForm() {
                this.$refs.reviewModal.setModalVisibility(true);
            },
            postReview() {
                axios.post('/postreview', {
                    product_id: this.product.id,
                    order_id: this.product.order_id,
                    pluses: this.review.pluses,
                    minuses: this.review.minuses,
                    comment: this.review.comment,
                })
                .then(res => {
                    this.$refs.reviewModal.setModalVisibility(false);
                    this.$eventBus.$emit('postReview', this.product);
                });
            }
        },
    }
</script>
<style lang="scss" scoped>
    .modal-header {
        font-size: 1.5rem !important;
    }
</style>
