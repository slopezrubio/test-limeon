<template>
    <div class="input-field col s10">
        <select name="building" id="building">
            <option v-for="item in items" value="item.name">{{ item.name }}</option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "BasicSelector",
        props: {
            items: Array,
        },
        data() {
            return {

            }
        },
        methods: {
            initSelect: function() {
                let element = this.$el.querySelector('select');
                M.FormSelect.init(element, this.items)
            }
        },
        created() {

        },
        mounted() {
            this.initSelect();
        }
    }
</script>

<style scoped>

</style>