<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id', 'user_id', 'balance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
