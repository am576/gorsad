<template>
    <nav class="pl-4">
        <ul class="pagination">
            <li class="page-item" v-if="pagination.current_page > 1">
                <a class="page-link" href="javascript:void(0)" aria-label="Назад" v-on:click.prevent="changePage(pagination.current_page - 1)">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <li class="page-item" v-for="page in pagesNumber" :class="{'active': page == pagination.current_page}">
                <a class="page-link" href="javascript:void(0)" v-on:click.prevent="changePage(page)">{{ page }}</a>
            </li>
            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                <a class="page-link" href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1)">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
        <label>Показывать</label>
        <select @change="changePerPage($event.target.value)">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <span>записей</span>
    </nav>
</template>

<script>
    export default {
        props: {
            pagination: {
                type: Object,
                require: true
            },
            offset: {
                type: Number,
                default: 4
            }
        },
        computed: {
            pagesNumber() {
                if (!this.pagination.to) {
                    return [];
                }
                let from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                let to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                let pagesArray = [];
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page);
                }
                return pagesArray;
            }
        },
        methods : {
            changePage(page) {
                this.pagination.current_page = page;
                this.$emit('paginate', page);
            },
            changePerPage(per_page) {
                this.$emit('changePerPage', per_page)
            }
        }
    }
</script>
