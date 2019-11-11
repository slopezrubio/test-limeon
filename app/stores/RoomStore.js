const RoomStore = {
    data: {
        debug: true,
    },
    methods: {
        getRoomsByApartment: async ($id) => {
            let response = await fetch('/api/apartments/' + $id + '/rooms', {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                }
            });

            return await response.json();
        }
    },
}

export default RoomStore;