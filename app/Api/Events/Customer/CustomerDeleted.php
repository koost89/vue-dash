<?php
namespace App\Api\Events\Customer;

use App\Api\Events\BillingEvents;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CustomerDeleted extends BillingEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customer_id;
    /**
     * Create a new event instance.
     * @param $customer_id
     */
    public function __construct($customer_id)
    {
        $this->customer_id = $customer_id;
    }
}