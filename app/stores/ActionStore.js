const ActionStore = {
    data: {
        debug: true,
    },
    methods: {
        deleteActionById: async (id) => {
            let url = '/actions/delete/' + id;
            let response = await fetch(url, {
               method: 'DELETE',
            }).then(response => { window.location.reload() });
        },
        editAction: async (action) => {
            let url = '/actions/edit/' + action.id;
        }
    }
}

export default ActionStore;