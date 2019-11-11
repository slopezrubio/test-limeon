<template>
    <div class="input-field col s10">
        <input type="text" class="datepicker">
        <label :for="input.id">{{ input.value }}</label>
    </div>
</template>

<script>
    export default {
        name: 'DatePicker',
        props: {
            input: Object,
        },
        methods: {
            init: function() {
                var elem = this.$el.querySelector('.datepicker');
                var instances = M.Datepicker.init(elem, this.input.options);
            }
        },
        mounted() {
            this.init();
        }
    }
</script>

<style lang="scss">

</style>