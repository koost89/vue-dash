import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './views/Login'
import Home from './views/Home'
import Projects from './views/Projects'
import Customers from './views/Customers'
import Billings from './views/Billings'
import store from './store/index'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'login',
            component: Login,
        },
        {
            path: '/home',
            name: 'home',
            component: Home,
        },
        {
            path: '/projects',
            name: 'projects',
            component: Projects,
        },
        {
            path: '/customers',
            name: 'customers',
            component: Customers,
        },
        {
            path: '/billings',
            name: 'billings',
            component: Billings,
        },
    ],
});

router.beforeEach((to, from, next) => {
        if (!store.getters['auth/isLoggedIn'] && to.name !== 'login') {
            next('/')
            return
        }

    //  ORIGINAL REFRESH FOR PAGES, MOST LOGIC MOVED TO APP.VUE
        //
        // let tokenTime = parseInt(localStorage.getItem('expires_at'),10)
        // let currentTime = parseInt(new Date().getTime(), 10)
        // let refreshTime = parseInt(tokenTime - (10*1000), 10);
        //
        // let tokenIsExpiringSoon = currentTime > refreshTime
        //
        // console.log('token expiring soon: ' + tokenIsExpiringSoon )
        // console.log('date now: ' + currentTime)
        // console.log('toke exp: ' + tokenTime)
        // console.log('refresh : ' + refreshTime)
        //
        // if (tokenIsExpiringSoon && store.getters.authStatus !== 'loading') {
        //     attemptRefresh()
        //         .then(() => {
        //             next();
        //             return
        //         })
        //         .catch(()=> {
        //             store.dispatch('logout')
        //             next('/');
        //         })
        // }
        next()
    }

)

export default router;