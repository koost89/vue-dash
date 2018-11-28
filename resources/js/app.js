import Vue from 'vue'
import App from './views/App'
import router from './router'
import Echo from 'laravel-echo'

if (process.env.MIX_APP_ENV === 'production') {
    Vue.config.devtools = false;
    Vue.config.debug = false;
    Vue.config.silent = true;
}

window.io = require('socket.io-client');

// const token = localStorage.getItem('token')
// if (token) {
//     Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer ' + token
// }

if (window.io != undefined) {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001',
    });
}
const app = new Vue({
    el: '#app',
    components: { App },
    router
});


