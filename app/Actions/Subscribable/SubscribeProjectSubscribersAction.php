<?php

namespace App\Actions\Subscribable;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class SubscribeProjectSubscribersAction
{
    protected SubscribeAction $subscribeAction;

    public function __construct(SubscribeAction $subscribeAction)
    {
        $this->subscribeAction = $subscribeAction;
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(Model $model): void
    {
        $subscribedProjectUsers = $model->load('project.subscribers')->project->subscribers;
        $this->subscribeAction->execute($model, $subscribedProjectUsers);
    }
}
