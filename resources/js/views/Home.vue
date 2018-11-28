<template>
    <div>
        Holler2
    </div>
</template>
<script>
    import axios from 'axios'
    import echo from '../mixins/echo'
    export default {

        created() {},
        computed: {},
        mixins: [echo],
        data() {
            return {
                projectId:  this.$route.path.substr(1),
                weather: [],
                energy: [],
            }
        },
        methods: {
            getEventHandlers() {
                return {
                    'Weather\\WeatherFetched': response => {
                        this.weather = response.weather;
                    },
                    'ServiceHouse\\EnergyDataFetched': response => {
                        console.log(response)
                        this.energy = response;
                    },
                };
            },
        }
    }
</script>
