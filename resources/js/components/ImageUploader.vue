<template>
    <div class="uploader"
         :class="{dragging: isDragging}"
    >
        <div class="dropin"
            @dragenter.self.stop.prevent="onDragIn($event)"
            @dragleave.self.stop.prevent="onDragOut($event)"
            @drop.self.stop.prevent="onDrop($event)"
            @dragover.prevent
        >
            <i class="mdi mdi-cloud-upload"></i>
            <p>Перетащите файлы</p>
            <div>ИЛИ</div>
        </div>
        <div class="file-input">
            <label for="file">Выберите файл</label>
            <input type="file" id="file" multiple @change="onInputChange">
        </div>
        <div class="card" v-show="images.length">
            <div class="card-header d-flex flex-row">
                <div class="m-auto">Загруженные изображения</div>
            </div>
            <div class="card-body">
                <div class="images-preview" v-show="images.length">
                    <div class="img-wrapper" v-for="(image, index) in images" :key="index">
                        <img :src="image" :alt="index">
                        <i class="mdi mdi-close-circle-outline" @click.prevent="removeImage(index)"></i>
                        <div class="image-details">
                            <span class="image-name" v-text="files[index].name" :title="files[index].name"></span>
                            <span class="image-size" v-text="files[index].size + ' байт'"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
          isDragging: false,
          files: [],
          images: []
        }),
        methods : {
            onInputChange(e) {
                const files = e.target.files;
                Array.from(files).forEach(file => this.addImage(file));

                this.passImages();
            },
            onDragIn(e) {
                this.isDragging = true;
            },
            onDragOut(e) {
                this.isDragging = false;
            },
            onDrop(e) {
                this.isDragging = false;

                const files = e.dataTransfer.files;
                Array.from(files).forEach(file => this.addImage(file));

                this.passImages();
            },
            addImage(file) {
                if(!file.type.match('image.*'))
                {
                    console.log(`Файл ${file.name} не является изображением`);
                    return;
                }
                this.files.push(file);
                const reader = new FileReader();

                reader.onload = (e) => this.images.push(e.target.result);
                reader.readAsDataURL(file);
            },
            removeImage(index) {
                this.$delete(this.files, index);
                this.$delete(this.images, index);

                this.passImages();
            },
            passImages() {
                this.$eventBus.$emit('addImages', this.files)
            },
            uploadImages() {
                const formData = new FormData();

                this.files.forEach(file => {
                    formData.append('images[]', file, file.name);
                })

                axios.post('/admin/images-upload', formData)
                .then(resposne => {
                    alert('Изображения успешно загружены');
                    // this.images = [];
                    // this.files = [];
                })
            }
        }

    }
</script>

<style lang="scss" scoped>
    $color-blue : #00b7ff;
    .uploader {
        width: 100%;
        background: $color-blue;
        color: white;
        padding: 40px 15px;
        border-radius: 10px;
        border: 3px dashed white;
        text-align: center;
        font-size: 24px;
        position: relative;

        &.dragging {
            background: white;
            color: $color-blue;
            border-color: $color-blue;
        }

        .dropin {
            * {
                pointer-events: none;
            }
        }

        i {
            font-size: 85px;
        }

        .file-input {
            width: 200px;
            margin: auto;
            position: relative;
            height: 70px;

            label,
            input {
                background: white;
                width: 100%;
                color: $color-blue;
                position: absolute;
                left: 0;
                top: 0;
                padding: 10px;
                border-radius: 4px;
                margin-top: 15px;
                cursor: pointer;
            }

            input {
                opacity: 0;
                z-index: -2;
            }
        }

        .card {
            color: #000;
        }

        .images-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;

            .img-wrapper {
                position: relative;
                width: 150px;
                display: flex;
                flex-direction: column;
                margin: 10px;
                height: 220px;
                justify-content: space-between;
                box-shadow: 5px 5px 20px #000;
                background: #fff;

                img {
                    max-height: 150px;
                }

                i {
                    position: absolute;
                    top: 0;
                    right: 0;
                    line-height: 24px;
                    font-size: 24px;

                    cursor: pointer;

                    &:hover {
                        line-height: 26px;
                        font-size: 26px;
                        color: coral;
                    }
                }

            }

            .image-details {
                width: 100%;
                height: 60px;
                background: #fff;
                color: #000;
                display: flex;
                flex-direction: column;
                align-items: self-start;
                padding: 3px 6px;
                font-size: 16px;

                .image-name {
                    overflow: hidden;
                    text-overflow: ellipsis;
                    width: 100%;
                }
            }
        }
    }
</style>
