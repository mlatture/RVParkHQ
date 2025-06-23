<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimPark extends Model
{
    protected $table = 'claim_parks';
    protected $guarded = [];

    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['park'])) {
            $query->whereHas('park', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['park'] . '%');
            });
        }

        if (!empty($filters['user'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['user'] . '%');
            });
        }

        return $query;
    }


    public function park()
    {
        return $this->belongsTo(Park::class, 'park_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
