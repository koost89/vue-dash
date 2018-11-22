<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = ['project_id', 'customer_id', 'description', 'note', 'hourly_rate', 'estimate_hours', 'worked_hours', 'total_amount'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
