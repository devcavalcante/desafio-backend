<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    public $incrementing = false;

    protected $fillable = [
        'id', 'type'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
