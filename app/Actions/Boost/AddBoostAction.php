<?php

namespace App\Actions\Boost;

use Auth;
use App\User;
use App\Models\Contracts\BoostContract;
use App\Models\Boost;

class AddBoostAction
{

    public function execute(array $attributes, BoostContract $model, ?User $user = null): Boost
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        return $model->boost($user, $attributes);
    }
}
