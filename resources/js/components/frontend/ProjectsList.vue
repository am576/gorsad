<template>
    <div class="row justify-content-center projects-list">
        <p class="projects-page-title">Проекты, которыми стоит гордиться</p>
        <div class="row projects-container">
            <div class="project-block"  v-for="project in projects">
                <img height="100" :src="project.img_path" alt="">
                <p class="project-name">{{project.name}}</p>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                projects: [
                    {
                        name: 'ул. Аэропортная',
                        img_path: '/storage/images/projects/project-01.jpg'
                    }
                ],
                shouldLoadProjects : false,
                deltaScroll : 600
            }
        },
        methods: {
            populateProjects(count) {
                let i = 1, len = count;
                let r = 1;
                while(i < len) {
                    r =  this.getRandomInt(1,6);
                    let tmp = {
                        name: 'ул. Аэропортная',
                        img_path : '/storage/images/projects/project-0' + r + '.jpg'
                    }

                    this.projects.push(tmp);
                    i++;
                }
            },
            getRandomInt(min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min)) + min;
            },
            handleScroll () {
                this.shouldLoadProjects = window.scrollY > this.deltaScroll;
                if(this.projects.length < 50 && this.shouldLoadProjects) {
                    this.populateProjects(6);
                    this.deltaScroll += 500;
                }
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
            @media (max-width: 590px) {
                justify-content: center;
            }

            .project-block {
                @media (min-width: 591px) {
                    width: 30%;
                    img {
                        width: 100%;
                        height: 300px;
                    }
                }
                @media (max-width: 590px) {
                    width: 50vh;
                    img {
                        width: 100%;
                        height: 50vh;
                    }
                }
                display: flex;
                margin-bottom: 25px;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background-position: center;
                background-size: cover;

                .project-name {
                    position: absolute;
                    color: #fff;
                    font-size: 30px;
                    font-weight: bold;
                }
            }
        }

    }

</style>
