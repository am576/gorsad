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
        <div class="images-preview" v-show="images.length">
            <div class="img-wrapper" v-for="(image, index) in images" :key="index">
                <img :src="image" :alt="index">
                <div class="image-details">
                    <span class="image-name" v-text="files[index].name"></span>
                    <span class="image-size" v-text="files[index].size"></span>
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
                console.log(e);
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
    }
</style>
