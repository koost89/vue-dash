import Vue from 'vue'
import axios from 'axios'
import App from './views/App'
import router from './router'
import Echo from 'laravel-echo'

window.io = require('socket.io-client');

Vue.prototype.$http = axios.create();

// const token = localStorage.getItem('token')
// if (token) {
//     Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer ' + token
// }

if (window.io != undefined) {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001',
    });
    window.Echo.channel('dashboard');
}


const app = new Vue({
    el: '#app',
    components: { App },
    router
});


