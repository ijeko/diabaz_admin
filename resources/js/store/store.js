export default {
    state: {
        materials: [],
        products: [],
        produced: [],
        machines: [],
        productMaterialNorms: [],
        incomes: [],
        materialsQty: [],
        motohours: [],
        sold: [],
        stock: [],
        date: new Date().toISOString().slice(0, 10)

    },
    getters: {    // Fetch the total number of items in the cart
        MACHINES: state => {
            return state.machines;
        },
        MOTOHOURS: state => {
            return state.motohours
        },
        MATERIALS: state => {
            return state.materials;
        },
        PRODUCTS: state => {
            return state.products
        },
        PRODUCED: state => {
            return state.produced
        },
        SOLD: state => {
            return state.sold
        },
        STOCK: state => {
            return state.stock
        },
        PRODUCT_MATERIAL_NORMS: state => {
            return state.productMaterialNorms
        },
        INCOMES: state => {
            return state.incomes
        },
        MATERIAL_QTY: state => {
            return state.materialsQty
        },
        DATE: state => {
            return state.date
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
        SET_SOLD: (state, data) => {
            state.sold = data;
        },
        SET_STOCK: (state, data) => {
            state.stock = data;
        },
        SET_MOTOHOURS: (state, data) => {
            state.motohours = data;
        },
        SET_MACHINES: (state, data) => {
            state.machines = data;
        },
        SET_SELECTED_NORM: (state, data) => {
            state.productMaterialNorms = data;
        },
        SET_INCOMES: (state, data) => {
            state.incomes = data;
        },
        SET_MATERIALS_QTY: (state, data) => {
            state.materialsQty = data;
        },
        SET_DATE: (state, date) => {
            state.date = date
        }
    },
    actions: {
        // GET_MATERIALS: ({commit}) => {
        //     axios.get('/api/materials/get', {
        //         headers: {'Content-Type': 'application/json'}
        //     })
        //         .then(function (response) {
        //             commit('SET_MATERIALS', response.data);
        //             return response.data
        //         })
        //         .catch(function (error) {
        //             // handle error
        //             console.log(error);
        //         })
        // },
        GET_MATERIALS: ({commit}) => {
            return axios.get('/api/materials', {
                headers: {'Content-Type': 'application/json'}
            })
                .then(response => {
                    commit('SET_MATERIALS', response.data);
                    return response.status
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })

        },
        GET_PRODUCTS: ({commit}, data) => {
            return axios.get('/api/products', {
                headers: {'Content-Type': 'application/json'},
                params: data

            })
                .then(response => {
                    commit('SET_PRODUCTS', response.data);
                    return response.status
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        GET_PRODUCED: ({commit}, data) => {
            axios.get('/api/produced/get',
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
            axios.post('/api/produced/add',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(function (response) {
                    // commit('SET_PRODUCED', response.data)
                    return data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        GET_SOLD: ({commit}, data) => {
            axios.get('/api/products/sold',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: data
                })
                .then(function (response) {
                    commit('SET_SOLD', response.data);
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        GET_STOCK: ({commit}, data) => {
            axios.get('/api/products/getstock',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: data
                })
                .then(function (response) {
                    commit('SET_STOCK', response.data);
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        ADD_SOLD: ({commit}, data) => {
            axios.post('/api/products/sold',
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
        ADD_MOTOHOURS: ({commit}, data) => {
            axios.post('/api/motohours/',
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
        GET_MACHINES: ({commit}, data) => {
            return axios.get('/api/machines', {
                headers: {'Content-Type': 'application/json'},
                params: data
            })
                .then(response => {
                    commit('SET_MACHINES', response.data);
                    return response.status
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        GET_MOTOHOURS: ({commit}, data) => {
            axios.get('/api/motohours/',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: data
                })
                .then(function (response) {
                    commit('SET_MOTOHOURS', response.data);
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        GET_NORM_BY_MATERIAL: ({commit}, data) => {
            axios.get('/api/matnorm/get',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: data
                })
                .then(function (response) {
                    commit('SET_SELECTED_NORM', response.data);
                    console.log(response.data)
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        EDIT_SELECTED_NORM: ({commit}, data) => {
            axios.post('/api/matnorm/edit',
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
        GET_INCOMES: ({commit}, data) => {
            axios.get('/api/incomes/get',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: data
                })
                .then(function (response) {
                    commit('SET_INCOMES', response.data);
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
        ADD_INCOME: ({commit}, data) => {
            axios.post('/api/incomes/add',
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
        SET_DATE: ({commit}, date) => {
            axios.get('/api/workdate',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: {currentDate: date}
                })
            console.log(date)
            commit('SET_DATE', date);
        }
    }

};
