<template>
    <div class="input-field col s10">
        <select class="browser-default" @change="updateOptions" v-for="(values, key, index) in options" :name="key" :id="key" v-model="selected" :required="true" :aria-required="true">
            <option v-for="(value, key) in values" :value="value.id">{{ value.name }}</option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "BasicSelector",
        props: {
            options: Object,
        },
        watch: {
          options: function() {
              /*var instance = M.FormSelect.getInstance(this.getSelector(Object.keys(this.options)[0]));
             this.initSelect();*/
              this.selected = this.options[Object.keys(this.options)[0]][0].id;
          }
        },
        data() {
            return {
                selected: this.options[Object.keys(this.options)[0]][0].id
            }
        },
        methods: {
            initSelect: function() {
                for (let item in this.options) {
                    let element = this.getSelector(item);
                    M.FormSelect.init(element);
                }
            },
            getSelector: function(name) {
                return this.$el.querySelector('select[name=' + name + ']');
            },
            updateOptions: function() {
                this.$emit('selected', this.selected);
            }
        },
        created() {
            console.log(this.options);
        },
        mounted() {
            this.initSelect();
        }
    }
</script>

<style scoped>

</style>