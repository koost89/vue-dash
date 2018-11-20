<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = ['name', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
