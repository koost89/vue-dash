<template>
    <div>
        <h1>Vue Router Demo App</h1>

        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'test' }">Test</router-link> |
            <router-link v-if="isLoggedIn" :to="{ name: 'customers' }">Klanten</router-link> |
            <router-link v-if="!isLoggedIn" :to="{ name: 'login' }">Login</router-link>
            <span v-if="isLoggedIn"><a @click="logout">Logout</a></span>

        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'
    import Echo from 'laravel-echo'
    import { mapState, mapGetters } from 'vuex'
    import store from '../store/index'

    export default {
        data() {
            return {
                authCheckTimeout: null,
            }
        },
        computed : {
            ...mapState({
                token: state => state.auth.token,

            }),
            ...mapGetters('auth', {
                isLoggedIn: 'isLoggedIn',
                authStatus: 'authStatus'
            })
        },
        methods: {
            logout: function () {
                this.$store.dispatch('auth/logout')
                    .then(() => {
                        this.$router.push('/')
                    })
            },
            attemptRefresh(){
                return new Promise((resolve, reject) => {
                    let token = localStorage.getItem('token');
                    this.$store.dispatch('auth/refresh', token).then(response => {
                        console.log('attemptRefresh resolve')
                        resolve()
                    }).catch(err => {
                        reject()
                    })
                });
            }
        },
        beforeCreate(){
            window.Echo = new Echo({
                broadcaster: 'socket.io',
                host: window.location.hostname +':6001',
                auth: {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    },
                },
            });
        },
        created: function () {

            // Add echo to the app
            window.Echo.private('billing').listenForWhisper('test', (e) => console.log('YAYs'));

            if(this.isLoggedIn){

            } else {
                window.Echo.leave('billing');
            }
            // Axios interceptor for refreshing oauth tokens
            this.$http.interceptors.request.use((config) => {
                return new Promise((resolve, reject) => {
                    let tokenTime = parseInt(localStorage.getItem('expires_at'),10)
                    let currentTime = parseInt(new Date().getTime(), 10)
                    let refreshTime = parseInt(tokenTime - (10*1000), 10);

                    let tokenIsExpiringSoon = currentTime > refreshTime
                    console.log('token expiring soon: ' + tokenIsExpiringSoon )

                    if (tokenIsExpiringSoon && this.authStatus !== 'loading') {
                        this.attemptRefresh()
                            .then(() => {
                                console.log('returning resolveded config')
                                config.headers['Authorization'] = 'Bearer ' + this.token
                                resolve(config);
                            })
                            .catch(()=> {
                                this.$store.dispatch('auth/logout')
                                reject();
                            })
                    }
                    else {
                        if(this.authStatus !== 'loading') {
                            console.log('returning original config')
                            config.headers['Authorization'] = 'Bearer ' + this.token
                            resolve(config);
                        }
                        reject();
                    }
                })
            })
        }
    }
</script>