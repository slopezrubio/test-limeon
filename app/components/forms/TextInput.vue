<template>
    <div class="input-field col s10">
        <input type="text" :name="input.id" :id="input.id" class="validate">
        <label :for="input.id">{{ input.id.replace('-', ' ').charAt(0).toUpperCase() + input.id.substr(1) }}</label>
    </div>
</template>

<script>
    export default {
        name: "TextInput",
        props: {
            input: Object,
        },
    }
</script>

<style scoped>

</style>