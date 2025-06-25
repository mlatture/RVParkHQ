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
        
        if (!empty($filters['global_search'])) {
            $global_search = ucwords(str_replace('-', ' ', $filters['global_search']));
            $query->where('name', 'like', "%{$global_search}%");
        }

        return $query;
    }

    public function winnerParks()
    {
        return $this->hasMany(WinnerPark::class, 'park_id');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_park')->withTimestamps();
    }

    public function editRequests()
    {
        return $this->hasMany(ParkEditRequest::class, 'park_id');
    }

    public function claim_parks()
    {
        return $this->hasMany(ClaimPark::class, 'park_id');
    }
}
