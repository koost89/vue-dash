import axios from 'axios';

class Weather {
        conditions(city) {
        return new Promise((resolve, reject) => {
            const queryCurrentCondition = `select item.condition from weather.forecast where woeid in (select woeid from geo.places(1) where text='${city}') and u='c'`;
           this.performQuery(queryCurrentCondition).then(response => {
                resolve(response.data.query.results.channel.item.condition)
            }).catch(error => {
                reject(error);
            });
        })
    }

    forecast(city) {
        return new Promise((resolve, reject) => {
            const queryForecast = `select item.forecast from weather.forecast where woeid in (select woeid from geo.places(1) where text="${city}") and u='c' limit 5`;
            this.performQuery(queryForecast).then(response => {
                resolve(response.data.query.results.channel)
            }).catch(error => {
                reject(error);
            });
        })
    }

    async performQuery(query) {
            return new Promise((resolve, reject) => {
                const endpoint = `https://query.yahooapis.com/v1/public/yql?q=${query}&format=json`;
                axios.get(endpoint).then( response => resolve(response)).catch(error => reject(error));
            })
    }
}

export default new Weather();