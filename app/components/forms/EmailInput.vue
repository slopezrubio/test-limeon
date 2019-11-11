<template>
    <div class="input-field col s10">
        <input type="email" :id="input.id" :name="input.id" class="validate">
        <label :for="input.id">{{ input.value ? input.value : input.id.replace('-', ' ').charAt(0).toUpperCase() + input.id.substr(1) }}</label>
        <span class="helper-text" data-error="wrong" data-success="right">{{ input.placeholder }}</span>
    </div>
</template>

<script>
    export default {
        name: "EmailInput",
        props: {
            input: Object,
        },
    }
</script>

<style scoped>

</style>