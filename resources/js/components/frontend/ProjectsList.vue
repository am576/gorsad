<template>
    <div class="row justify-content-center projects-list">
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
    .projects-list {
        max-width: 1150px;
        justify-content: center;
        .projects-container {
            display: flex;
            justify-content: space-between;
            width: 100%;

            .project-block {
                width: 30%;
                display: flex;
                margin-bottom: 25px;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background-position: center;
                background-size: cover;
                img {
                    width: 100%;
                    height: 300px;
                }
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
