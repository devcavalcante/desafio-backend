<?php

namespace App\Observers;

use App\Models\User;
use Ramsey\Uuid\Uuid;

trait UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */

    protected static function boot()
    {
        parent::boot();
        static::created(function (User $user) {
            $user->wallet()->create([
                'id' => Uuid::uuid4()->toString(),
                'balance' => 0
            ]);
        });
    }
}
