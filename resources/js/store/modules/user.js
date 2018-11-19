import axios from 'axios'


const state = {
    user: '',
}

const getters = {
    user: state => state.user,
}

const actions = {
    fetchedUser({commit}, user){
        return new Promise((resolve, reject) => {
            commit('user_fetched', user)
            resolve();
        })
    },
}
const mutations = {
    user_fetched(state, user){
        state.user = user
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}