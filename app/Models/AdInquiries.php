<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdInquiries extends Model
{
    protected $table = 'ad_inquiries';
    
    protected $guarded = [];
    
    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('company', 'like', "%{$term}%")
                    ->orWhere('interest', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%");
            });
        }

        return $query;
    }
}