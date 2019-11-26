<template>
    <div class="input-field col s12">
        <input type="email" :value="input.default" :id="input.id" :name="input.id" class="validate" :class="{ invalid: input.error !== ''}">
        <label :class="{ active: input.default !== '' }" :for="input.id">{{ input.label ? input.label : input.id.replace('-', ' ').charAt(0).toUpperCase() + input.id.substr(1) }}</label>
        <span class="helper-text" :data-error="input.error">{{ input.placeholder }}</span>
    </div>
</template>

<script>
    export default {
        name: "EmailInput",
        props: {
            input: Object,
        }
    }
</script>

<style scoped>

</style>