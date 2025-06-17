<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $table = 'amenities';
    protected $guarded = [];

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('amenity', 'LIKE', "%{$term}%")
                    ->orWhere('category', 'LIKE', "%{$term}%");
            });
        }

        return $query;
    }

    public function parks()
    {
        return $this->belongsToMany(Park::class, 'amenity_park');
    }
}
