const BuildiingStore = {
    data: {
        debug: true,
    },
    methods: {
        getApiRequest: async ($method) => {
            let response = await fetch('/api/buildings', {
                method: $method,
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                },
                
            });

            return await response.json();
        }
    }
}

export default BuildiingStore;