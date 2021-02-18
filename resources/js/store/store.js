
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
        GET_MATERIALS: () => {
            axios.get('products/get', {
            })
                .then(function (response) {
                    // handle success
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            // context.commit('SET_MATERIALS', data);
        },
        GET_PRODUCTS: (context, data) => {
            context.commit('SET_PRODUCTS', data);
        },
        GET_PRODUCED: (context, data) => {
            context.commit('SET_PRODUCED', data)
        },
        GET_MACHINES: (context, data) => {
            context.commit('SET_MACHINES', data)
        },
    },
};
