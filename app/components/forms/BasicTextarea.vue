<template>
    <div class="input-field col s10">
        <textarea :name="textarea.id" :id="textarea.id" class="materialize-textarea"></textarea>
        <label :for="textarea.id">{{ textarea.placeholder }}</label>
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