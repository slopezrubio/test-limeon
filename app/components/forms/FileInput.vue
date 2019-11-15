<template>
    <div class="file-field input-field col s10">
        <div class="btn">
            <span>File</span>
            <input v-if="input.multiple" type="file" :name="input.id" multiple>
            <input v-else type="file" :name="input.id">
        </div>
        <div class="file-path-wrapper">
            <input type="text" class="file-path validate" :placeholder="input.placeholder ? input.placeholder : defaultPlaceholder">
        </div>
    </div>
</template>

<script>
    export default {
        name: "file-input",
        props: {
            input: Object,
        },
        data() {
            return {
                defaultPlaceholder: 'Upload your file'
            }
        },
        mounted() {

        }
    }
</script>

<style scoped>

</style>