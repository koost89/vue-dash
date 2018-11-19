import Vue from 'vue'
import axios from 'axios'
import store from './store/index'
import App from './views/App'
import router from './router'
window.io = require('socket.io-client');

Vue.prototype.$http = axios.create();

// const token = localStorage.getItem('token')
// if (token) {
//     Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer ' + token
// }

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});


