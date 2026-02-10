<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkPhoto extends Model
{
    protected $guarded = [];

    public function park()
    {
        return $this->belongsTo(Park::class);
    }
}
