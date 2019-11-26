<template>
    <div class="input-field col s12">
        <input type="text" :name="input.id" class="datepicker">
        <label :for="input.id">{{ input.value }}</label>
    </div>
</template>

<script>
    export default {
        name: 'DatePicker',
        props: {
            input: Object,
        },
        data() {
            return {
                picker: null,
                instances: null,
            }
        },
        methods: {
            init: function() {
                this.picker = this.$el.querySelector('.datepicker');
                this.instances = M.Datepicker.init(this.picker, this.input.options);
                this.instances.options.onOpen = () => {
                    this.setMinDate();
                };
            },
            setMinDate: function() {
                if (this.instances.options.minDate === null) {
                    this.instances.options.minDate = new Date(Date.now());
                }
            },
        },
        mounted() {
            this.init();
        }
    }
</script>

<style lang="scss">

</style>