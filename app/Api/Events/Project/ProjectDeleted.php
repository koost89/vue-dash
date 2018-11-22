<?php
namespace App\Api\Events\Project;

use App\Api\Events\BillingEvents;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProjectDeleted extends BillingEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project_id;
    /**
     * Create a new event instance.
     * @param $customer_id
     */
    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }
}