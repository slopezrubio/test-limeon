<template>
    <div class="input-field col s10">
        <input type="text" :name="input.id" :id="input.id" class="validate" :class="{ invalid: input.error !== '' }">
        <label :for="input.id">{{ input.id.replace('-', ' ').charAt(0).toUpperCase() + input.id.substr(1) }}</label>
        <span class="helper-text" :data-error="input.error"></span>
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