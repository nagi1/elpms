<?php

namespace App\Actions\Event;

use Auth;
use App\User;
use App\Models\Event;
use App\Models\Contracts\EventContract;

class AddEventAction
{

    public function execute(array $attributes, EventContract $model, ?User $user = null): Event
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        return $model->userDid($user, $attributes);
    }
}
