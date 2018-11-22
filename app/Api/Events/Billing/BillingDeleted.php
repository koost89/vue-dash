<?php
namespace App\Api\Events\Billing;

use App\Api\Events\BillingEvents;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class BillingDeleted extends BillingEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $billing_id;
    /**
     * Create a new event instance.
     * @param $billing_id
     */
    public function __construct($billing_id)
    {
        $this->billing_id = $billing_id;
    }
}