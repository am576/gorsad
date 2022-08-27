<template>
    <div class="modal-overlay" :class="[showModal ? 'd-flex' : 'd-none']">
        <div class="gmodal" :class="modal_class">
            <span class="close-modal mdi mdi-close-circle-outline" @click="showModal = false"></span>
            <slot name="header"></slot>
            <slot></slot>
            <slot name="footer"></slot>
        </div>
        <div class="close-modal">
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            modal_class: '',
            id: ''
        },
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
                if(this.id && this.id === args) {
                    this.showModal = args;
                }

            },
        },
        computed: {

        },
        created: function() {
            document.addEventListener('keyup', this.keyPressed);
            this.$eventBus.$on('showModal', this.setModalVisibility)
        }
    }
</script>
