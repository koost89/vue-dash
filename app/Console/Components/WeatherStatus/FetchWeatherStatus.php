<?php

/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 26-11-2018
 * Time: 23:28
 */
namespace App\Console\Components\WebsiteStatus;
use App\Api\YahooWeather\WeatherApi;
use App\Events\Weather\WeatherFetched;
use Illuminate\Console\Command;

class FetchWeatherStatus extends Command {

    protected $signature = 'dashboard:fetch-weather-status';
    protected $description = 'Fetch the weather from Yahoo';

    public function handle()
    {
        $weather = new WeatherApi();
        $weatherConditions = $weather->request();
//        foreach($weatherConditions as $condition){
//          Save in DB so we can pull them on page load instead of querying the KNMI API
//        }
        event(new WeatherFetched($weather));
    }
}