<template>
    <div class="input-field s10">
        <select name="building" id="building">
            <option v-for="building in buildings"></option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "BasicSelector",
        props: {

        },
        data() {

        }
    }
</script>

<style scoped>

</style>