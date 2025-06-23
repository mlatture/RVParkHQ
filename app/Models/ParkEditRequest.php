<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkEditRequest extends Model
{
    protected $table = 'park_edit_requests';
    protected $guarded = [];

    public function scopeSearch($query, $term)
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->whereHas('park', function ($q2) use ($term) {
                $q2->where('name', 'like', '%' . $term . '%');
            })
                ->orWhereHas('owner', function ($q3) use ($term) {
                    $q3->where('name', 'like', '%' . $term . '%')
                        ->orWhere('email', 'like', '%' . $term . '%');
                });
        });
    }

    public function park()
    {
        return $this->belongsTo(Park::class, 'park_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
