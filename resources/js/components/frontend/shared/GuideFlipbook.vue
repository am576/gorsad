<template>
    <flipbook class="flipbook" :pages="image_names" :zooms="[1,2]"></flipbook>
</template>

<script>
    export default {
        components: { Flipbook },
        props: {
            image_names: []
        },
    }
</script>
<style lang="scss">
    .flipbook {
        width: 90vw;
        height: 90vh;
        margin: 0 auto;
    }
</style>
