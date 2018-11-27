<?php

namespace App\Api\YahooWeather;

use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 26-11-2018
 * Time: 23:45
 */
class WeatherApi
{
    private $baseUrl = 'https://query.yahooapis.com/v1/public/yql?q=';
    private $baseEndUrl = '&format=json';

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

//    const queryForecast = 'select item.forecast from weather.forecast where woeid in (select woeid from geo.places(1) where text=$city) and u="c" limit 5';

    public function getCurrentCondition($city)
    {
        $query = 'select item.condition from weather.forecast where woeid in (select woeid from geo.places(1) where text="'.$city.'") and u="c"';
        return $this->request($query);
    }

    public function request($query)
    {
        $response = $this->client->get($this->baseUrl . $query . $this->baseEndUrl);
        $data = $response->getBody()->getContents();
        return $data;
    }
}