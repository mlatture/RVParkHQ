<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hit extends Model
{
    protected $table = 'hits';
    
    protected $guarded = [];

    public function park()
    {
        return $this->belongsTo(Park::class, 'park_id');
    }
}
