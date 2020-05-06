<?php

namespace App\Actions\Boost;

use Auth;
use App\User;
use App\Models\Boost;

class DeleteBoostAction
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(Boost $boost, ?User $user = null): void
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $boost->delete();
    }
}
