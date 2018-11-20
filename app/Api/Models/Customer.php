<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = ['name'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

}
