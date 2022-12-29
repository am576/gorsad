<template>
    <Transition>
        <div id="banner" v-if="show">
            <slot/>
            <i id="close-banner" class="mdi mdi-36px mdi-close text--white" @click="closeBanner"></i>
        </div>
    </Transition>
</template>

<script>
    export default {
        data() {
            return {
                show: false
            }
        },
        methods: {
            closeBanner() {
                this.show = false;
                axios.post('/closeBanner');
            },
            showBanner() {
                this.show = true;
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.showBanner();
            });
        },
        created() {

        }
    }
</script>

<style lang="scss" scoped>
    #banner {
        position: relative;
        width: 100%;
        padding: 20px;
        background-color: #242424;
        border: 1px solid #42b883;
        border-radius: 8px;
        color: #ffffff;

        #close-banner {
            position: absolute;
            right: 1%;
            top: 0;
            cursor: pointer;
        }
    }
    .v-enter-active,
    .v-leave-active {
        transition: opacity 1s ease;
    }
    .v-enter-to,
    .v-leave-from{
        opacity: 1;
    }

    .v-enter-from,
    .v-leave-to {
        opacity: 0;
    }
</style>
