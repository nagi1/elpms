<?php

namespace App\Actions\Subscribable;



use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class SubscribeAction
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
    public function execute(Model $model, Collection $users): void
    {
        $users->each(function ($user) use ($model) {
            $user->subscribe($model);
        });
    }
}
