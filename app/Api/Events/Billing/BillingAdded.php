<?php
namespace App\Api\Events\Billing;

use App\Api\Events\BillingEvents;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class BillingAdded extends BillingEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $billing;
    /**
     * Create a new event instance.
     * @param $billing
     */
    public function __construct($billing)
    {
        $this->billing = $billing;
    }
}