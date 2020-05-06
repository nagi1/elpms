<?php

namespace App\Actions\Boost;

use Auth;
use App\User;
use App\Models\Concerns\Boostable;
use App\Models\Boost;

class AddBoostAction
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
    public function execute(array $attributes, Boostable $model, ?User $user = null): Boost
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        return $model->boost($user, $attributes);
    }
}
