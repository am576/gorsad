<template>
<div class="container">
    <div class="row">
        <div class="hbwr mb-sm-3 col-md-4 col-sm-12 d-flex justify-content-center" v-for="service in services">
            <div class="home-block">
                <div class="header" :style="{'background-image': 'url('+service.image+')'}">
                    <p class="text-center">{{service.title}}</p>
                </div>
                <div class="description">
                    <div>{{service.description}}</div>
                    <a class="block-link">
                        <div class="mr-3">{{service.btn_title}}</div>
                        <span class="mdi mdi-chevron-right-circle-outline mdi-24px"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data() {
            return {
                services: [
                    {
                        title: 'Высадка деревьев',
                        description: 'Ищете, кто может помочь в высадке/пересадке деревьев?',
                        btn_title: 'Воспользуйтесь нашей услугой',
                        image: '/storage/images/public/home-blocks/home-block1.jpg',
                        url: '/'
                    },
                    {
                        title: 'Как ухаживать за деревьями',
                        description: 'Мы собрали для вас передовой опыт лучших специалистов',
                        btn_title: 'Современные технологии заботы',
                        image: '/storage/images/public/home-blocks/home-block2.jpg',
                        url: '/'
                    },
                    {
                        title: 'Вазоны и приствольные решетки в пространстве',
                        description: 'Аксессуары для деревьев, которые меняют привычное восприятие общественного пространства',
                        btn_title: 'Посмотрите, как это выглядит',
                        image: '/storage/images/public/home-blocks/home-block3.jpg',
                        url: '/'
                    },
                    {
                        title: 'Проекты, которыми можно гордиться',
                        description: 'Мы сотрудничаем с нащими клиентами, чтобы обеспечить успешное завершение проектов',
                        btn_title: 'Разделите нашу гордость',
                        image: '/storage/images/public/home-blocks/home-block4.jpg',
                        url: '/projects/all'
                    },
                    {
                        title: 'Стили в ладншафтном дизайне',
                        description: 'Познакоьтесь со всеми основными стилями и выберите лучшего специалиста для себя',
                        btn_title: 'Посмотреть все стили',
                        image: '/storage/images/public/home-blocks/home-block5.jpg',
                        url: '/'
                    },
                    {
                        title: 'С чего начать, чтобы потом не переделывать',
                        description: 'Познакомьтесь с правилами ландшафтного искусства при организации своего пространства',
                        btn_title: 'Советы, которые работают',
                        image: '/storage/images/public/home-blocks/home-block6.jpg',
                        url: '/'
                    }
                ]
            }
        }
    }
</script>
<style lang="scss" scoped>
    .container {
        background: #fefdf9;
        padding: 50px 20px;
        max-width: 1250px;

        .col-4 {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            margin-bottom: 75px;
        }

        .hbwr {
            @media (max-width: 590px) {
                margin-bottom: 3vh;
            }
        }
        .home-block {
            width: 90%;
            display: flex;
            flex-direction: column;
            /*margin-bottom: 75px;*/
            color: #ffffff;
            height: 100%;

            .header {
                display: flex;
                justify-content: center;
                align-items: flex-end;
                font-size: 26px;
                height: 380px;
                background-size: cover;
                width: 100%;
                line-height: 38px;

                p {
                    text-transform: uppercase;
                    font-weight: bold;
                    padding: 0 10px;
                    text-shadow: 0 5px 7px rgba(0,0,0,0.8);
                }
            }

            .description {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                background: #055e32;
                padding: 25px;
                height: 35%;

                .block-link {
                    color: inherit;
                    text-decoration: none;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: flex-end;
                }
                &:hover {
                    color: inherit;
                    text-decoration: none;
                }
            }
        }
    }
</style>
