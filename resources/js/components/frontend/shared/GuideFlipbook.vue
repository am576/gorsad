<template>
    <flipbook class="flipbook" :pages="images" :zooms="[1,2]"></flipbook>
</template>

<script>
    export default {
        components: { Flipbook },
        props: {
            guide_name: ''
        },
        data()  {
            return {
                images: [

                ],
                names : []
            }
        },
        methods: {
            getImageNames() {
                axios.get('/api/getGuideImageNames',
                    {
                        params: {
                            guide_name: this.guide_name
                        }
                    }).then(response => {
                        this.images = response.data;
                })
            }
        },
        created() {
            this.getImageNames();
        }
    }
</script>
<style lang="scss">
    .flipbook {
        width: 90vw;
        height: 90vh;
        margin: 0 auto;
    }
</style>
