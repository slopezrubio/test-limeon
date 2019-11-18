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
                <tr>
                    <td>
                        <tr>
                            <td>
                                {{ value.action.responsable }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ value.action.email_responsable }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ value.building }}
                            </td>
                        </tr>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "job-list",
        props: {
            actions: Array
        },
        data() {
            return {

            }
        },
        created() {
            console.log(this.actions);
        }
    }
</script>

<style scoped>

</style>