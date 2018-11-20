<?php
namespace App\Api\Events\Customer;

use App\Api\Events\BillingEvents;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CustomerUpdated extends BillingEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customer;
    /**
     * Create a new event instance.
     * @param $customer
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }
}