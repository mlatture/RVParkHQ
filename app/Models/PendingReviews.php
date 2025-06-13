<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingReviews extends Model
{
    protected $table = 'pending_reviews';
    protected $guarded = [];

    public function park()
    {
        return $this->belongsTo(Park::class, 'park_id');
    }
}
