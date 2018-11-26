<?php
namespace App\Api\Events\Project;

use App\Api\Events\BillingEvents;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProjectAdded extends BillingEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project;
    /**
     * Create a new event instance.
     * @param $project
     */
    public function __construct($project)
    {
        $this->project = $project;
    }
}