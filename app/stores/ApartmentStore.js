const ApartmentStore = {
    data: {
        debug: true,
    },
    methods: {
        getApartmentsByBuilding: async (id) => {
            let response = await fetch('/api/buildings/' + id + '/apartments', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                }
            });

            return await response.json();
        }
    }
}

export default ApartmentStore;