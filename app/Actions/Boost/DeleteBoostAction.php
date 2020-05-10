<?php

namespace App\Actions\Boost;

use Auth;
use App\User;
use App\Models\Boost;

class DeleteBoostAction
{
    public function execute(Boost $boost, ?User $user = null): void
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $boost->delete();
    }
}
