<template>
    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Название</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Принадлежит</label>
                    <category-selector :select_name="'parent_id'"></category-selector>
                </div>
                <div class="form-group">
                    <label>Описание</label>
                    <input type="text" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Создать</button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {

        methods: {
            submit() {
                console.log(1);
            }
        },
        created() {
            this.$eventBus.$on('changeCategory', () => {
                console.log('1');
            });
        }
    }
</script>
