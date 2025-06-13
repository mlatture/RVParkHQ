<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    use HasFactory;

    protected $table = 'parks';
    protected $guarded = [];

    public function scopeFilter($query, $filters)
    {
        if (!is_array($filters)) return $query;

        if (!empty($filters['country'])) {
            $country = ucwords(str_replace('-', ' ', $filters['country']));
            $query->where('country', 'like', "%{$country}%");
        }

        if (!empty($filters['state'])) {
            $state = ucwords(str_replace('-', ' ', $filters['state']));
            $query->where('state', 'like', "%{$state}%");
        }

        if (!empty($filters['city'])) {
            $city = ucwords(str_replace('-', ' ', $filters['city']));
            $query->where('city', 'like', "%{$city}%");
        }
        if (!empty($filters['states'])) {
            $query->where('state', 'like', "%{$filters['states']}%");
        }

        return $query;
    }
}
