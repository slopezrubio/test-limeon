<template>
    <div class="row">
        <div class="col s12 m12 offset-l3 l6 offset-xl3 xl6">
            <div class="card">
                <div class="row class-content">
                    <div class="col s12 card-title">
                        <div class="card-title__text col s10">Job Log</div>
                    </div>
                    <div class="card-body col s12">
                        <basic-selector v-if="buildings" v-bind:items="buildings"></basic-selector>
                    </div>
                    <div class="card-body col s12">
                        <basic-selector v-if="apartments" v-bind:items="apartments"></basic-selector>
                    </div>
                </div>
                <div class="row card-action">
                    <a href="#">Send</a>
                    <a href="#">Erase</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BuildingStore from '../stores/BuildingStore.js';
    import ApartmentStore from '../stores/ApartmentStore.js';
    import BasicSelector from './forms/BasicSelector.vue';

    export default {
        name: "JobLogForm",
        components: {
            'basic-selector': BasicSelector
        },
        data() {
            return {
                buildings: null,
                apartments: null,
                rooms: null,
            }
        },
        methods: {
            getBuildings: async function() {
                this.buildings = await BuildingStore.methods.getApiRequest('GET');
                this.apartments = await ApartmentStore.methods.getApartmentsByBuilding(this.buildings[0].id);
            }
        },
        created() {
            this.getBuildings('GET');
        },
        mounted() {

        }
    }
</script>

<style scoped>

</style>