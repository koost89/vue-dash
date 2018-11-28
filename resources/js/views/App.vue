<template>
    <div>
        <h1>Servicehouse Dashboard</h1>
        <p>
            <!--<router-link :to="{ name: 'home' }">Home</router-link> |-->
        </p>

        <div class="page view">
                <router-view></router-view>
        </div>
    </div>
</template>
<script>

    export default {
        created() {
            const project_id_route = this.$router.currentRoute.path;
            const project_id = project_id_route.substr(1);
            localStorage.setItem('project_id', project_id);
        },
        data() {
            return {
            }
        }
    }
</script>