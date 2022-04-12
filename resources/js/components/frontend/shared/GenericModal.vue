<template>
    <div class="modal-overlay" :class="showModal ? 'd-flex' : 'd-none'">
        <div class="gmodal">
           <slot></slot>
        </div>
        <div class="close">
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showModal: false
            }
        },
        methods: {
            keyPressed(event) {
                if (event.keyCode === 27) {
                    this.showModal = false;
                }
            },
            setModalVisibility(args) {
                this.showModal = true;
            }
        },
        computed: {

        },
        created: function() {
            document.addEventListener('keyup', this.keyPressed);
            this.$eventBus.$on('showModal', this.setModalVisibility)
        }
    }
</script>
<style lang="scss" scoped>
    .modal-overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        justify-content: center;
        background-color: #000000da;
        z-index: 100;

        .gmodal {
            text-align: center;
            background-color: #fff6ea;
            height: 500px;
            width: 500px;
            margin-top: 10%;
            padding: 40px 0;
            input.form-control {
                width: 70%;
                margin: 0 auto 1rem;
                line-height: 24px;
                font-size: 24px;
            }
        }
    }

</style>
