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
        },
        data() {
            return {
                user: null,
            }
        }
    }
</script>
