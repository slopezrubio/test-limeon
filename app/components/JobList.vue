<template>
    <div class="container col s12 m6">
        <table class="striped" v-for="(value, key) in actions">
            <thead>
                <tr>
                    <th>Details</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "job-list",
        props: {
            actions: Object
        },
        data() {
            return {

            }
        }
    }
</script>

<style scoped>

</style>