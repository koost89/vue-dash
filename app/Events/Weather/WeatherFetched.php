<?php
namespace App\Events\Weather;

use App\Events\DashboardEvents;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class WeatherFetched extends DashboardEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $weather;

    /**
     * Create a new event instance.
     * @param $weather
     * @internal param $project
     */
    public function __construct($weather)
    {
        $this->weather = $weather;
    }
}