<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    protected $fillable = [
        'user_id',
        'card_number',
        'expiry',
        'cvc',
    ];

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'card_id');
    }
} 