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
        $weather = $weather->getCurrentCondition('Amersfoort, NL');
//        dd($weather);
        event(new WeatherFetched($weather));
    }
}