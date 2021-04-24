<template>
    <b-modal :id="modal_id" title="Оставить отзыв" cancel-disabled>
        <div>
            <b-form-input class="mt-2" v-model="review.pluses" placeholder="Достоинства"></b-form-input>
            <b-form-input class="mt-2" v-model="review.minuses" placeholder="Недостатки"></b-form-input>
            <b-form-input class="mt-2" v-model="review.comment" placeholder="Комментарий"></b-form-input>
        </div>
        <template #modal-footer="{ ok }">
            <b-button size="sm" variant="success" @click="postReview">
                Сохранить
            </b-button>
        </template>
    </b-modal>
</template>

<script>
    export default {
        props: {
            modal_id: '',
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
            postReview() {
                axios.post('/postreview', {
                    product_id: this.product.id,
                    order_id: this.product.order_id,
                    pluses: this.review.pluses,
                    minuses: this.review.minuses,
                    comment: this.review.comment,
                })
                .then(res => {
                    this.$bvModal.hide(this.modal_id);
                    this.$eventBus.$emit('postReview', this.product);
                });
            }
        },
    }
</script>
