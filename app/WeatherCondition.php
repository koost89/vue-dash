<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeatherCondition extends Model
{
    protected $fillable = ['chill', 'pressure', 'rv', 'station', 'temp', 'weather', 'wind', 'wind_direction', 'visibility'];
}
