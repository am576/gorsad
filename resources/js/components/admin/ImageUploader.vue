<template>
    <div class="product_images images-container">
        <div v-show="!isSingleImage && existing_images.length" class="card">
            <div class="card-header">Сохранённые изображения</div>
            <div class="card-body">
                <div class="images-preview" v-show="existing_images.length">
                    <div class="img-wrapper" v-for="(image, index) in existing_images" :key="index">
                        <img :src="'/storage/images/' +image.icon" :alt="index" :title="image.icon.match(/[^\/]*$/)">
                        <i class="mdi mdi-close-circle-outline" @click.prevent="removeProductImage(image.id, index)"></i>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="(isSingleImage && isImageEmpty) || !isSingleImage" class="uploader"
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
                    <div class="m-auto"></div>
                </div>
                <div class="card-body">
                    <div class="images-preview" v-show="images.length">
                        <div class="img-wrapper" v-for="(image, index) in images" :key="index">
                            <img :src="image" :alt="index">
                            <i class="mdi mdi-close-circle-outline" @click.prevent="removeUploadedImage(index)"></i>
                            <div class="image-details">
                                <span class="image-name" v-text="files[index].name" :title="files[index].name"></span>
<!--                                <span class="image-size" v-text="files[index].size + ' байт'"></span>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="isSingleImage && !isImageEmpty" class="images-preview">
                <div class="img-wrapper" :class="[isSingleImage ? 'single_image_wrapper' : '']">
                    <img class="single-image" :src="single_image">
                    <i class="mdi mdi-close-circle-outline" @click.prevent="removeSingleImage()"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            entity_id: 0,
            entity_model: '',
            entity: {},
            isSingleImage: false,
            storage: ''
        },
        data: () => ({
            isDragging: false,
            disabled: false,
            files: [],
            images: [],
            existing_images: [],
            current_image: {}
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

                if(this.isSingleImage)
                {
                    reader.onload = (e) => this.current_image = e.target.result;
                }
                else
                {
                    reader.onload = (e) => this.images.push(e.target.result);
                }

                reader.readAsDataURL(file);

            },
            removeSingleImage() {
                if(typeof this.current_image !== 'string')
                {
                    this.$emit('removeImage', this.current_image.id);
                }
                this.current_image = {};
            },
            removeUploadedImage(index) {
                this.$delete(this.files, index);
                this.$delete(this.images, index);

                this.passImages();
            },
            removeProductImage(image_id, index) {
                this.$delete(this.existing_images, index);
                this.$emit('removeImage', image_id)
            },
            passImages() {
                this.$eventBus.$emit('addImages', this.files)
            },
            getImages()
            {
                axios.get('/api/getImages',{
                    params: {
                        id: this.entity_id,
                        model: this.entity_model,
                    }
                })
                .then(response => {
                    if(!this.isSingleImage){
                        this.existing_images = this.entity.images;
                    }
                    if(this.isSingleImage)
                        if(typeof this.entity.images[0] !== 'undefined')
                        this.current_image = this.entity.images[0];
                })
            },

        },
        computed: {
            single_image() {
                if (this.entity_id)
                {
                    return typeof this.current_image === 'string' ? this.current_image : '/storage/images/' +  this.current_image.large;
                }
                else
                {
                    return this.current_image;
                }

            },
            isImageEmpty() {
                if(typeof this.current_image === 'undefined')
                {
                    return Object.keys(this.current_image).length === 0
                }
                else if(typeof this.current_image === 'string')
                {
                    return this.current_image.length === 0
                }
                else
                {
                    return Object.keys(this.current_image).length === 0
                }
            }
        },
        created() {
            if(this.entity_id)
            {
                this.getImages()
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

    .product_images {
        position: relative;

        .images-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;

            .img-wrapper.single_image_wrapper {
                max-width: 50% !important;
            }

            .img-wrapper {
                position: relative;
                display: flex;
                flex-direction: column;
                margin: 10px;
                justify-content: space-between;
                box-shadow: 5px 5px 20px #000;
                background: #e8e8e8;

                img {
                    max-height: 250px;
                    min-height: 150px;
                }

                img.single-image {
                    max-width: 100% !important;
                    height: auto !important;
                    max-height: 100%;
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
        }


    }
</style>
