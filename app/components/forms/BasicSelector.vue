<template>
    <div class="input-field col s12">
        <select @change="updateOptions" v-for="(values, key, index) in select" :name="key" :id="key" v-model="selected" :required="true" :aria-required="true">
            <option v-for="(value, key) in values" :value="value.id">{{ value.name }}</option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "BasicSelector",
        props: {
            select: Object,
            default: [Object, String],
        },
        watch: {
            select: function() {
                this.selected = this.select[Object.keys(this.select)[0]][0].id
            },
        },
        data() {
            return {
                selector: null,
                selected: this.default !== '' ? this.default.id : this.select[Object.keys(this.select)[0]][0].id,
                instance: null
            }
        },
        methods: {
            initSelect: function() {
                for (let item in this.select) {
                    this.selector = this.getSelector(item);
                    this.instance = M.FormSelect.init(this.selector);
                }
            },
            getSelector: function(name) {
                return this.$el.querySelector('select[name=' + name + ']');
            },
            updateOptions: function() {
                this.$emit('selected', this.selected);
            }
        },
        mounted() {
            this.initSelect();
        },
        updated() {
            $(this.selector).formSelect('destroy');
            this.selector = this.getSelector(Object.keys(this.select)[0]);
            this.instance = M.FormSelect.init(this.selector);
        }
    }
</script>

<style scoped>

</style>