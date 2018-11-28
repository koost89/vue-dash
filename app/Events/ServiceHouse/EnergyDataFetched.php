<?php
namespace App\Events\ServiceHouse;

use App\Events\DashboardEvents;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class EnergyDataFetched extends DashboardEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $project_id;

    public $energyData;

    /**
     * Create a new event instance.
     * @param $energyData
     * @param $project_id
     * @internal param $project
     */
    public function __construct($energyData, $project_id)
    {
        $this->project_id = $project_id;
        $this->energyData = $energyData;
    }

    public function broadcastOn()
    {
        return new Channel('dashboard.' . $this->project_id);
    }
}