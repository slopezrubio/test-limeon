<template>
    <div class="card-body col s12" v-if="selectors.rooms.options">
        <basic-selector @selected="updateApartments" :default="selectors.buildings.default" :select="selectors.buildings.options"></basic-selector>
        <basic-selector @selected="updateRooms" v-model="selectors.apartments.options" :default="selectors.apartments.default" :select="selectors.apartments.options"></basic-selector>
        <basic-selector v-model="selectors.rooms.options" :default="selectors.rooms.default" :select="selectors.rooms.options"></basic-selector>
        <basic-textarea :textarea="textarea.description"></basic-textarea>
        <phone-number-input :input="phoneNumberInput.phoneResponsable"></phone-number-input>
        <date-picker :input="datePicker.dateOfWork"></date-picker>
        <text-input :input="textInput.responsable"></text-input>
        <email-input :input="emailInput.emailResponsable"></email-input>
        <file-input :input="fileInput.actionFiles"></file-input>
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
    import FileInput from "./forms/FileInput.vue";

    export default {
        name: "job-log-form",
        components: {
            'basic-selector': BasicSelector,
            'text-input': TextInput,
            'email-input': EmailInput,
            'basic-textarea': BasicTextarea,
            'date-picker': DatePicker,
            'phone-number-input': PhoneNumberInput,
            'file-input': FileInput
        },
        props: {
            errors: {
                type: [Object, null],
                required: false,
                default: function() { return {} }
            },
            action: {
                type: [Object, null],
                required: false,
                default: function() { return {} }
            }
        },
        data() {
            return {
                selectors: {
                    buildings: {
                        options: null,
                        default: this.action.building !== undefined ? this.action.building : ''
                    },
                    apartments: {
                        options: null,
                        default: this.action.apartment !== undefined ? this.action.apartment : ''
                    },
                    rooms: {
                        options: null,
                        default: this.action.room !== undefined ? this.action.room : ''
                    },
                },
                textInput: {
                    responsable: {
                        placeholder: 'Steve Stifler',
                        id: 'responsable',
                        default: this.action.responsable !== undefined ? this.action.responsable : '',
                        error: this.errors.responsable !== undefined ? this.errors.responsable : ''
                    },
                },
                textarea: {
                    description: {
                        placeholder: 'Type here a short description of the task',
                        id: 'description',
                        default: this.action.description !== undefined ? this.action.description : '',
                        error: this.errors.description !== undefined ? this.errors.description : ''
                    },
                },
                emailInput: {
                    emailResponsable: {
                        placeholder: 'e.g.: stevestifler@limeon.co',
                        id: 'email-responsable',
                        label: 'Email Responsable',
                        default: this.action.emailResponsable !== undefined ? this.action.emailResponsable : '',
                        error: this.errors.email_responsable !== undefined ? this.errors.email_responsable : ''
                    }
                },
                datePicker: {
                    dateOfWork: {
                        options: {
                            firstDay: 1,
                            minDate: this.action.dateOfWork !== undefined ? null : new Date(Date.now()),
                            format: 'mm/dd/yyyy',
                            defaultDate: this.action.dateOfWork !== undefined ? new Date(this.action.dateOfWork.timestamp * 1000) : new Date(Date.now()),
                            setDefaultDate: true,
                        },
                        id: 'date-of-work',
                        value: 'Date of Work',
                        error: this.errors.date_of_work !== undefined ? this.errors.date_of_work : ''
                    }
                },
                phoneNumberInput: {
                    phoneResponsable: {
                        id: 'phone-number-responsable',
                        placeholder: 'Phone Number',
                        selectedPrefix: this.action.phoneNumberResponsable !== undefined ? this.action.phoneNumberResponsable.prefix : 'fr',
                        default: this.action.phoneNumberResponsable !== undefined ? this.action.phoneNumberResponsable.phone_number : '',
                        error: this.errors.phoneNumber !== undefined ? this.errors.phoneNumber : ''
                    }
                },
                fileInput: {
                    actionFiles: {
                        placeholder: 'Upload one or more files',
                        id: 'action-files',
                        multiple: true,
                        error: this.errors["attached_files[0]"] !== undefined ? this.errors["attached_files[0]"] : ''
                    }
                }
            }
        },
        methods: {
            getFormData: async function() {
                this.selectors.buildings.options = await this.getBuildings();
                this.selectors.apartments.options = this.action.building !== undefined ? await this.getApartments(this.action.building.id) : await this.getApartments();
                this.selectors.rooms.options = this.action.apartment !== undefined ? await this.getRooms(this.action.apartment.id) : await this.getRooms();
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
                    apartments: await ApartmentStore.methods.getApartmentsByBuilding(this.selectors.buildings.options.buildings[0].id)
                }
            },
            getRooms: async function(apartmentId = null) {
                if (apartmentId !== null) {
                    return {
                        rooms: await RoomStore.methods.getRoomsByApartment(apartmentId)
                    };
                }

                return {
                    rooms: await RoomStore.methods.getRoomsByApartment(this.selectors.apartments.options.apartments[0].id)
                }
            },
            updateApartments: async function(id = null) {
                this.selectors.apartments.options = await this.getApartments(id);
                this.updateRooms();
            },
            updateRooms: async function(id = null) {
                this.selectors.rooms.options = await this.getRooms(id);
            }
        },
        created() {
            this.getFormData();
        }
    }
</script>

<style scoped>

</style>