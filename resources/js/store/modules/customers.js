
const state = {
    customers: [],
}


const actions = {

    fetchedCustomers({commit}, customers){
        return new Promise((resolve, reject) => {
            commit('CUSTOMERS_FETCHED', customers)
            resolve();
        })
    },

    customerAdded({commit}, customer){
        return new Promise((resolve, reject) => {
            commit('CUSTOMER_ADDED', customer)
            resolve();
        })
    }
}
const mutations = {
    CUSTOMERS_FETCHED(state, customers){
        state.customers = customers
    },
    CUSTOMER_ADDED(state, customer){
        state.customers.push(customer)
    },
}

const getters = {
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}