<template>
    <div class="input-field col s10">
        <textarea :name="textarea.id" :id="textarea.id" class="materialize-textarea validate" :class="{ invalid: textarea.error !== '' }"></textarea>
        <label :for="textarea.id">{{ textarea.placeholder }}</label>
        <span class="helper-text" :data-error="textarea.error">A short description of the task</span>
    </div>
</template>

<script>
    export default {
        name: "BasicTextarea",
        props: {
            textarea: Object,
        },
    }
</script>

<style scoped>

</style>