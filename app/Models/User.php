<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, HasApiTokens, UserObserver;

    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'email', 'document'
    ];

    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
