<template>
    <div>
        <h1>Dashboardi</h1>
        <p>
            <!--<router-link :to="{ name: 'home' }">Home</router-link> |-->
        </p>

        <div class="page view">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'
    import Echo from 'laravel-echo'

    export default {
        data() {
            return {}
        },
        beforeCreate(){
        },
    }
</script>