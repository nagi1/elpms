<?php

namespace App\Actions\Subscription;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class UnsubscribeAction
{
    public function execute(Model $model, Collection $users): void
    {
        $users->each(function ($user) use ($model) {
            $user->unsubscribe($model);
        });
    }
}
