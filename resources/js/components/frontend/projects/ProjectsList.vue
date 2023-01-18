<template>
    <div class="row justify-content-center projects-list">
        <p class="projects-page-title">Проекты, которыми стоит гордиться</p>
        <div class="row projects-container">
            <div class="project-block"  v-for="project in projects" @click="loadProjectPage(project.id)">

                <div class="project-image" v-bind:style="{'background-image':'url(/storage/images/' + project.images[0].medium +')'}"></div>
                <div class="project-bg" v-bind:style="{'background-image':'url(/storage/images/' + project.images[0].medium +')'}"/>
                <p class="project-name">{{project.name}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            projects: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                shouldLoadProjects : false,
                deltaScroll : 600
            }
        },
        methods: {
            loadProjectPage(id) {
                window.open('/projects/' + id, '_blank');
            },
            populateProjects(count) {

            },
            getRandomInt(min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min)) + min;
            },
            handleScroll () {
                /*this.shouldLoadProjects = window.scrollY > this.deltaScroll;
                if(this.projects.length < 50 && this.shouldLoadProjects) {
                    this.populateProjects(6);
                    this.deltaScroll += 500;
                }*/
            }
        },
        created() {
            this.populateProjects(12);
            window.addEventListener('scroll', this.handleScroll);
        },
        destroyed () {
            window.removeEventListener('scroll', this.handleScroll);
        }
    }
</script>

<style lang="scss" scoped>
    .projects-page-title {
        color: #707070;
        @media (min-width: 591px) {
            font-size: 5vh;
            margin-top: 4vh;
            margin-bottom: 10vh;
        }
        @media (max-width: 591px) {
            display: block;
            font-size: 3vh;
            color: #2a2525;
            margin-top: 7vh;
            margin-bottom: 5vh;
            width: 100%;
            background-color: #f6d6d6;
            text-align: center;
        }
    }
    .projects-list {
        max-width: 1150px;
        justify-content: center;
        @media (min-width: 591px) {
            margin-top: 50px;
        }
        .projects-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
            @media (max-width: 600px) {
                justify-content: center;
            }

            .project-block {
                @media (min-width: 591px) {
                    width: 30%;
                    height: 300px;
                    /*filter: blur(8px);*/
                    img {
                        width: 100%;
                        height: 300px;
                    }
                    .project-bg {
                        width: 100%;
                        height: 100%;
                        position: absolute;
                        left: 0;
                        top: 0;
                        background-size: 200%;
                        background-repeat: no-repeat;
                        filter: blur(3px);
                        -webkit-filter: blur(3px);
                    }
                    .project-image {
                        width: 250px;
                        height: 100%;
                        background-size: cover;
                        background-repeat: no-repeat;
                        z-index: 10;
                    }
                }
                @media (max-width: 600px) {
                    width: 50vh;
                    img {
                        width: 100%;
                        height: 50vh;
                    }
                }
                position: relative;
                display: flex;
                margin-bottom: 25px;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background-position: center;
                background-size: cover;
                cursor: pointer;

                .project-name {
                    position: absolute;
                    text-align: center;
                    width: 100%;
                    background: rgba(0, 0, 0, 0.15);
                    color: #fff;
                    margin: 0;
                    font-size: 30px;
                    font-weight: bold;
                    z-index: 11;
                }
            }
        }

    }

</style>
