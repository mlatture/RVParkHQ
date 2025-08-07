<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'bill_id',
        'user_id',
        'card_id',
        'amount',
        'payment_method',
        'processed_at',
        'status',
    ];

    public function bill()
    {
        return $this->belongsTo(\App\Models\Bill::class, 'bill_id');
    }
}
