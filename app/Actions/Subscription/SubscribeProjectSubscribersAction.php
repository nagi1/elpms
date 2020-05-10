<?php

namespace App\Actions\Subscription;

use Illuminate\Database\Eloquent\Model;

class SubscribeProjectSubscribersAction
{
    protected SubscribeAction $subscribeAction;

    public function __construct(SubscribeAction $subscribeAction)
    {
        $this->subscribeAction = $subscribeAction;
    }

    public function execute(Model $model): void
    {
        $subscribedProjectUsers = $model->load('project.subscribers')->project->subscribers;
        $this->subscribeAction->execute($model, $subscribedProjectUsers);
    }
}
