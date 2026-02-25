<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'wallet_id',
        'amount',
        'type',
    ];

    public function Wallet()
    {
        return $this->belongsTo(Wallet::class);
    }   
}
