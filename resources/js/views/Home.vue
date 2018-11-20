<template>
    <div v-if="user">
        <p>This is the homepage</p>
        <strong> {{ user }}</strong>
    </div>
</template>
<script>
    import axios from 'axios'

    export default {
        created() {
            this.$http
                .get('api/user')
                .then((response) => {
                    this.$store.dispatch('user/fetchedUser', response.data)
                })
                .catch(error => {console.log('ERROR FROM HOME' +  error)});
        },
        data() {
            return {
                user: null,
            }
        }
    }
</script>
