export default {
    state: {
        materials: [],
        products: [],
        produced: [],
        machines: ['zilok']
    },
    getters: {    // Fetch the total number of items in the cart
        MACHINES: state => {
            return state.machines;
        },
        MATERIALS: state => {
            return state.materials;
        },
        PRODUCTS: state => {
            return state.products
        },
        PRODUCED: state => {
            return state.produced
        }
    },
    mutations: {
        SET_MATERIALS: (state, data) => {
            state.materials = data;
        },
        SET_PRODUCTS: (state, data) => {
            state.products = data;
        },
        SET_PRODUCED: (state, data) => {
            state.produced = data;
        },
        SET_MACHINES: (state, data) => {
            state.machines = data;
        }
    },
    actions: {
        GET_MATERIALS: ({commit}) => {
            axios.get('http://127.0.0.1:8000/api/materials/get', {
                headers: {'Content-Type': 'application/json'}
            })
                .then(function (response) {
                    commit('SET_MATERIALS', response.data);
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        GET_PRODUCTS: ({commit}) => {
            axios.get('http://127.0.0.1:8000/api/products/get', {
                headers: {'Content-Type': 'application/json'}
            })
                .then(function (response) {
                    commit('SET_PRODUCTS', response.data);
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        GET_PRODUCED: ({commit}, data) => {
            axios.get('http://127.0.0.1:8000/api/produced/get',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: data
                })
                .then(function (response) {
                    commit('SET_PRODUCED', response.data);
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        ADD_PRODUCED: ({commit}, data) => {
            axios.post('http://127.0.0.1:8000/api/produced/add',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(function (response) {
                    return data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        GET_MACHINES: ({commit}) => {
            axios.get('http://127.0.0.1:8000/api/machines/get', {
                headers: {'Content-Type': 'application/json'}
            })
                .then(function (response) {
                    commit('SET_MACHINES', response.data);
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
    }
};