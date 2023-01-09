<template>
    <div class="row justify-content-center m-0">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 100%;">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="description open-sans">Широкий ассортимент деревьев и кустарников</div>
                </div>
                <!--<div class="carousel-item">
                    <img class="d-block w-100" :src="'/storage/images/public/home-slider/slider-1.jpg'" alt="Первый слайд">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" :src="'/storage/images/public/home-slider/slider-1.jpg'" alt="Первый слайд">
                </div>-->
            </div>
            <!--<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>-->
        </div>
    </div>
</template>

<script>
    export default {
    }
</script>

<style lang="scss" scoped>
    .carousel-inner {
        @media (min-width: 600px) {
            height: 820px;
            min-height: 820px;
        }
        @media (max-width:600px) {
            height: 40vh;
            min-height: 40vh;
        }

    }
    .carousel-item {
        height: 100%;
        background: url('/storage/images/public/home-slider/slider-1.jpg') center center;
        background-size: cover;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        align-items: center;
        color: #fff;
         .description {
             font-weight: bold;
             max-width: 50%;
             @media (min-width: 600px) {
                 font-size: 6vh;
             }
             @media (max-width:600px) {
                 font-size: 4vh;
             }

        }
    }
</style>
