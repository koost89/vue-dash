<?php
namespace App\Events\Weather;

use App\Events\DashboardEvents;
use App\Project;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class WeatherFetched extends DashboardEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $projectChannels;

    public $weather;

    /**
     * Create a new event instance.
     * @param $weather
     * @internal param $project
     */
    public function __construct($weather)
    {
        $projects = Project::all();
        foreach ($projects as $project){
            $this->projectChannels[] = 'dashboard.'.$project->id;
        }
        $this->weather = $weather;
    }

    public function broadcastOn()
    {
        return $this->projectChannels;
//        return new Channel('dashboard');
    }
}