<template>
    <div>
        Holler2
    </div>
</template>
<script>
    import axios from 'axios'
    import echo from '../mixins/echo'
    export default {

        created() {
        },
        mixins: [echo],
        data() {
            return {
                weather: [],
            }
        },
        methods: {
            getEventHandlers() {
                return {
                    'Weather\\WeatherFetched': response => {
                        this.weather = response.weather;
                    },
                };
            },
        }
    }
</script>
