<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Bill extends Model
{
    protected $table = 'bills';
    protected $guarded = [];

    public function scopeFilter($query, $search)
    {
        $query->when($search, function (Builder $q) use ($search) {
            $q->whereHas('user', function ($q2) use ($search) {
                $q2->where('name', 'like', "%{$search}%");
            })->orWhere('status', 'like', "%{$search}%");
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}