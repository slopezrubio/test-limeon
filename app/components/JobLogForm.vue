<template>
    <div class="row">
        <div class="col s12 m12 offset-l3 l6 offset-xl3 xl6">
            <div class="card">
                <div class="row class-content">
                    <div class="col s12 card-title">
                        <div class="card-title__text col s10">Job Log</div>
                    </div>
                    <div class="card-body col s12" v-if="selectors.rooms">
                        <basic-selector @selected="updateApartments" :options="selectors.buildings"></basic-selector>
                        <basic-selector @selected="updateRooms" v-model="selectors.apartments" :options="selectors.apartments"></basic-selector>
                        <basic-selector v-model="selectors.rooms" :options="selectors.rooms"></basic-selector>
                        <basic-textarea :textarea="textarea.description"></basic-textarea>
                        <phone-number-input :input="phoneNumberInput.phoneResponsable"></phone-number-input>
                        <date-picker :input="datePicker.dateOfWork"></date-picker>
                        <text-input :input="textInput.responsable"></text-input>
                        <email-input :input="emailInput.emailResponsable"></email-input>
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
    /* ------------------ STORES -------------------- */
    import BuildingStore from '../stores/BuildingStore.js';
    import ApartmentStore from '../stores/ApartmentStore.js';
    import RoomStore from '../stores/RoomStore.js';

    /* ---------------- COMPONENTS ------------------ */
    import BasicSelector from './forms/BasicSelector.vue';
    import TextInput from './forms/TextInput.vue';
    import BasicTextarea from './forms/BasicTextarea.vue';
    import EmailInput from './forms/EmailInput.vue';
    import DatePicker from './forms/DatePicker.vue';
    import PhoneNumberInput from './forms/PhoneNumberInput.vue';

    export default {
        name: "JobLogForm",
        components: {
            'basic-selector': BasicSelector,
            'text-input': TextInput,
            'email-input': EmailInput,
            'basic-textarea': BasicTextarea,
            'date-picker': DatePicker,
            'phone-number-input': PhoneNumberInput,
        },
        data() {
            return {
                selectors: {
                    buildings: null,
                    apartments: null,
                    rooms: null,
                },
                textInput: {
                    responsable: {
                        placeholder: 'Steve Stifler',
                        id: 'responsable',
                    },
                },
                textarea: {
                    description: {
                        placeholder: 'Type here a short description of the task',
                        id: 'description'
                    },
                },
                emailInput: {
                    emailResponsable: {
                        placeholder: 'e.g.: stevestifler@limeon.co',
                        id: 'email-responsable',
                        value: 'Email Responsable'
                    }
                },
                datePicker: {
                    dateOfWork: {
                        options: {
                            firstDay: 1,
                            minDate: new Date(Date.now()),
                        },
                        id: 'date-of-work',
                        value: 'Date of Work',
                    }
                },
                phoneNumberInput: {
                    phoneResponsable: {
                        id: 'phone-number-responsable',
                        value: 'Phone Number',
                        selectedPrefix: 'fr'
                    }
                }
            }
        },
        // watch: {
        //     apartments: function() {
        //         console.log("APARTMENTS");
        //     },
        //     rooms: function() {
        //         console.log("ROOMS");
        //     }
        // },
        methods: {
            getFormData: async function() {
                this.selectors.buildings = await this.getBuildings();
                this.selectors.apartments = await this.getApartments();
                this.selectors.rooms = await this.getRooms();
            },
            getBuildings: async function() {
                return {
                    buildings: await BuildingStore.methods.getApiRequest('GET')
                }
            },
            getApartments: async function(buildingId = null) {
                if (buildingId !== null) {
                    return {
                        apartments: await ApartmentStore.methods.getApartmentsByBuilding(buildingId)
                    };
                }

                return {
                    apartments: await ApartmentStore.methods.getApartmentsByBuilding(this.selectors.buildings.buildings[0].id)
                }
            },
            getRooms: async function(apartmentId = null) {
                if (apartmentId !== null) {
                    return {
                        apartments: await ApartmentStore.methods.getApartmentsByBuilding(apartmentId)
                    };
                }

                return {
                    rooms: await RoomStore.methods.getRoomsByApartment(this.selectors.apartments.apartments[0].id)
                }
            },
            updateApartments: async function(id = null) {
                this.selectors.apartments = await this.getApartments(id);
                this.updateRooms();
            },
            updateRooms: async function(id = null) {
                this.selectors.rooms = await this.getRooms(id);
            }
        },
        created() {
            this.getFormData();
        },
        mounted() {

        },
        updated() {

        }
    }
</script>

<style scoped>

</style>