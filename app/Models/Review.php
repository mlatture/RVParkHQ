<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    
    protected $guarded = [];
    
    public function park()
    {
        return $this->belongsTo(Park::class, 'park_id');
    }
}
