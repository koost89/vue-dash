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
use App\WeatherCondition;
use Illuminate\Console\Command;

class FetchWeatherStatus extends Command {

    protected $signature = 'dashboard:weather';
    protected $description = 'Fetch the weather from Yahoo';

    public function handle()
    {
        $weather = new WeatherApi();
        $weatherConditions = $weather->request();

        foreach($weatherConditions as $condition){
            WeatherCondition::updateOrCreate(
                ['station' => $condition['station']],
                [
                    'chill' => $condition['chill']  ?: NULL,
                    'pressure' => $condition['druk'] ?: NULL,
                    'rv' => $condition['rv']  ?: NULL,
                    'temp' => $condition['temp']  ?: NULL,
                    'weather' => $condition['weer']  ?: NULL,
                    'wind' => $condition['wind']  ?: NULL,
                    'wind_direction' => $condition['wind_direction']  ?: NULL,
                    'visibility' => $condition['zicht'] ?: NULL
                ]
            );
        }

        event(new WeatherFetched($weatherConditions));
    }
}