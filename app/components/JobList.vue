<template>
    <div class="container col s12 m6">
        <div v-if="actions.length > 0" class="row">
            <table class="striped action-table col s12" v-for="(value, key) in actions">
                <thead>
                    <tr class="row action-table__headers">
                        <th class="col s6">Details</th>
                        <th class="col s6">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="row">
                        <td class="col s6 action-table__details">
                            <tr>
                                <th>Responsable</th>
                            </tr>
                            <tr>
                                <td>
                                    <p>{{ value.action.responsable }}</p>
                                    <p>{{ value.action.email_responsable }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>{{ value.room }}</h5>
                                    <p>{{ value.apartment }}</p>
                                    <p>{{ value.building }}</p>
                                </td>
                            </tr>
                        </td>
                        <td class="col s6">
                            <tr>
                                <td>
                                    <a class="waves-effect waves-light btn" @click.stop.prevent="deleteItem" :href="'/actions/delete/' + value.action.id">
                                        <i class="medium material-icons right">delete</i>delete
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="waves-effect waves-light btn" :href="'/actions/' + value.action.id">
                                        <i class="medium material-icons right">edit</i>edit
                                    </a>
                                </td>
                            </tr>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="col s12">
                            <div class="extra-files">
                                <div v-if="value.action.attached_files.length > 0" class="fixed-action-btn">
                                    <a class="btn-floating btn-large blue">
                                        <i class="large material-icons">attach_file</i>
                                    </a>
                                    <ul>
                                        <li v-for="file in value.action.attached_files">
                                            <a class="btn-floating green"><i class="material-icons">attach_file</i></a>
                                            <span class="btn-floating--text">{{ file.originalName }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <div class="row">
                <table class="striped action-table">
                    <tr class="row">
                        <td class="col s12">
                            <p class="action-table__error-message">No task has been created yet, do you want to create some?</p>
                            <a :href="url.new" class=" action-table__error-btn waves effect waves-light btn-large"><i class="large left material-icons">add</i>new</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import ActionStore from '../stores/ActionStore.js';

    export default {
        name: "job-list",
        props: {
            actions: Array
        },
        data() {
            return {
                url: {
                    delete: '/actions/delete/',
                    edit: '/actions/',
                    new: '/actions/new'
                },
                floatingButtons: null,
                instance: null,
            }
        },
        methods: {
            deleteItem: function(event) {
                let itemId = event.target.href.match(/[0-9]+$/)[0];
                ActionStore.methods.deleteActionById(itemId);
            },
            floatingButtonsInit() {
                this.floatingButtons = document.querySelector('.fixed-action-btn') ? document.querySelector('.fixed-action-btn') : null;
                this.instance = M.FloatingActionButton.init(this.floatingButtons, {
                    direction: 'left',
                    hoverEnabled: true,
                });
            }
        },
        mounted() {
            this.floatingButtonsInit();
        }
    }
</script>

<style lang="scss" scoped>

    .action-table {
        &__headers {
            background: lightcoral;
            color: white;
            font-weight: 500;
            th {
                padding: 1em;
            }
        }

        &__error-message {
            color: grey;
            opacity: .7;
            font-size: 1em;
            text-align: center;
            padding: 1em 0;
        }

        &__error-btn {
            margin: 0 auto;
            width: 150px;
            display: block;
            font-size: 1.2em;

            i {
                font-size: 2.25rem;
            }
        }
    }

    .extra-files {
        position: relative;
        .fixed-action-btn {
            position: absolute;
            ul {
                li {
                    position: relative;
                    .btn-floating {
                        &--text {
                            float: left;
                            height: 1.5em;
                            transform: translateX(-50%);
                            left: 50%;
                            width: 300px;
                            position: absolute;
                            visibility: hidden;
                            text-align: center;
                            bottom: -30px;
                        }
                    }

                    &:hover {
                        .btn-floating {
                            &--text {
                                visibility: visible;
                            }
                        }
                    }
                }
            }
        }
    }
</style>