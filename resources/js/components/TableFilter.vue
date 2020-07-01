<template>
    <form>
        <div class="form-row">
            <div class="col-auto" v-for="(field, index) in filter_fields" :key="index">
                <label class="sr-only" :for="field.name">{{field.title}}</label>
                <input v-if="field.type === 'input'" type="text" class="form-control" :id="field.name" :name="field.name"
                       :placeholder="field.title" @keyup="updateFilterData(index, $event.target.value)">
                <select v-else-if="field.type === 'select'" :name="field.name" :id="field.name"
                        @change="updateFilterData(index, $event.target.value)">
                    <option v-for="option in field.options" :value="option.value">{{option.label}}</option>
                </select>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            filter_fields: {
                type: Array,
                default: []
            }
        },
        data() {
          return {
              filter_data: []
          }
        },
        methods: {
            updateFilterData(index, value) {
                console.log(`Before: ${JSON.stringify(this.filter_data)}`);
                if(value) {
                    const filter_data = {
                        name: this.filter_fields[index].name,
                        value: value,
                        type:  this.filter_fields[index].type,
                    };
                    this.$set(this.filter_data, index, filter_data);
                    console.log(`After: ${JSON.stringify(this.filter_data)}`);
                    this.emitFilter()
                }
            },
            emitFilter() {

                this.$emit('filter', this.filter_data);
            }
        },
        created() {

        }
    }
</script>
