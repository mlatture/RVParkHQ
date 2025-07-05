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

        if (!empty($filters['global_search'])) {
            $search = ucwords(str_replace('-', ' ', $filters['global_search']));
            $query->where('name', 'like', "%{$search}%");
        }

        // Amenity filter
        if (!empty($filters['amenities']) && is_array($filters['amenities'])) {
            $query->whereHas('amenities', function($q) use ($filters) {
                $q->whereIn('amenities.id', $filters['amenities']);
            });
        }

        if (!empty($filters['site_availability']) && is_array($filters['site_availability'])) {
            $query->whereHas('claim_parks', function ($q) use ($filters) {
                $q->where('status', 'approved');

                foreach ($filters['site_availability'] as $field => $minValue) {
                    if (!empty($minValue)) {
                        $q->where($field, '>=', (int)$minValue);
                    }
                }
            });
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
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($park) {
            do {
                $randomColor = sprintf("#%06X", mt_rand(0, 0xFFFFFF));
            } while (self::where('color', $randomColor)->exists());

            $park->color = $randomColor;
        });
    }
}
