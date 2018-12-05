<template>
    <transition name="fade" appear  mode="out-in">
        <div>
            Holler2
            <div v-show="weatherConditions" v-for="condition in weatherConditions" :key="condition.station">
                <div><strong>Station</strong> {{ condition.station }}</div>
                <div><strong>Temp</strong> {{ condition.temp }}</div>
                <div><strong>Wind</strong> {{ condition.wind }}</div>
                <div><strong>Windrichting</strong> {{ condition.wind_direction }} </div>
                <br>
                <br>
            </div>
        </div>
    </transition>
</template>
<script>
    import axios from 'axios'
    import echo from '../mixins/echo'
    export default {

        created() {
            let savedWeather = localStorage.getItem('savedWeather');
            if(savedWeather) {
                this.weatherConditions = JSON.parse(savedWeather);
            }
        },
        computed: {},
        mixins: [echo],
        data() {
            return {
                projectId:  this.$route.path.substr(1),
                weatherConditions: [],
                energy: [],
            }
        },
        methods: {
            getEventHandlers() {
                return {
                    'Weather\\WeatherFetched': response => {
                        this.weatherConditions = response.weather;
                        localStorage.setItem('savedWeather', JSON.stringify(this.weatherConditions));
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