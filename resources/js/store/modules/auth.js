import axios from 'axios'
import Vue from 'vue';

const state = {
    status: '',
    token: localStorage.getItem('token') || '',
}

const getters = {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status
}

const actions = {
    login({commit}, user){
        return new Promise((resolve, reject) => {
            commit('auth_request')
            axios({url: 'http://geldhark.kevin/login', data: user, method: 'POST' })
                .then(resp => {

                    const token = resp.data.access_token
                    const expires_in = resp.data.expires_in

                    localStorage.setItem('token', token)
                    localStorage.setItem('expires_in', expires_in)
                    localStorage.setItem('expires_at', new Date().getTime() + (expires_in * 1000));

                    commit('auth_success', token)

                    resolve(resp)
                })
                .catch(err => {
                    commit('auth_error')
                    localStorage.removeItem('token')
                    localStorage.removeItem('expires_in')
                    localStorage.removeItem('expires_at')

                    reject(err)
                })
        })
    },
    refresh({commit}, token){
        return new Promise((resolve, reject) => {
            commit('refresh_request')
            axios({url: 'http://geldhark.kevin/login/refresh', method: 'POST' })
                .then(resp => {

                    const token = resp.data.access_token
                    const expires_in = resp.data.expires_in

                    localStorage.setItem('token', token)
                    localStorage.setItem('expires_in', expires_in)
                    localStorage.setItem('expires_at', new Date().getTime() + (expires_in * 1000));

                    commit('refresh_success', token)
                    console.log('refresh resolve')
                    resolve(resp)

                })
                .catch(err => {
                    commit('refresh_error')
                    localStorage.removeItem('token')
                    localStorage.removeItem('expires_in')
                    localStorage.removeItem('expires_at')
                    reject(err)
                })
        })
    },
    logout({commit}){
        return new Promise((resolve, reject) => {
            commit('logout')
            localStorage.removeItem('token')
            localStorage.removeItem('expires_in')
            localStorage.removeItem('expires_at')
            delete Vue.prototype.$http.defaults.headers.common['Authorization']
            resolve()
        })
    }
}
const mutations = {
    auth_request(state){
        state.status = 'loading'
    },
    auth_success(state, token){
        state.status = 'success'
        state.token = token
    },
    auth_error(state){
        state.status = 'error'
    },
    refresh_request(state){
        state.status = 'loading'
    },
    refresh_success(state, token){
        state.status = 'success'
        state.token = token
    },
    refresh_error(state){
        state.status = 'error'
    },
    logout(state){
        state.status = ''
        state.token = ''
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}