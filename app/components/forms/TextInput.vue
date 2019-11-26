<template>
    <div class="input-field col s12">
        <input type="text" :value="input.default" :name="input.id" :id="input.id" class="validate" :class="{ invalid: input.error !== '' }">
        <label :class="{ active: input.default !== '' }" :for="input.id">{{ input.id.replace('-', ' ').charAt(0).toUpperCase() + input.id.substr(1) }}</label>
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