<?php

namespace App\Actions\Event;

use Auth;
use App\User;
use App\Models\Contracts\ChangeEventContract;
use App\Models\ChangeEvent;

class AddChangeEventAction
{

    public function execute(array $attributes, ChangeEventContract $model, ?User $user = null): ChangeEvent
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        return $model->userDid($attributes, $user);
    }
}
