<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id', 'payee_id', 'payer_id', 'value'
    ];

    public function payer()
    {
        return $this->belongsTo(Wallet::class, 'payer_id');
    }

    public function payee()
    {
        return $this->belongsTo(Wallet::class, 'payee_id');
    }
}
