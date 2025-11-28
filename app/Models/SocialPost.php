<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    protected $fillable = [
        'tenant_id',
        'tenant_name',
        'tenant_domain',
        'idea_id',
        'article_url',
        'variants',
        'media',
        'status',
        'scheduled_for',
    ];

    protected $casts = [
        'variants'      => 'array',
        'media'         => 'array',
        'scheduled_for' => 'datetime',
    ];
}
