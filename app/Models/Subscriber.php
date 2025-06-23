<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'subscribers';
    protected $guarded = [];

    public function scopeSearch($query, $term)
    {
        if (!empty($term)) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'LIKE', '%' . $term . '%')
                    ->orWhere('email', 'LIKE', '%' . $term . '%')
                    ->orWhere('zip_code', 'LIKE', '%' . $term . '%');
            });
        }

        return $query;
    }

}
