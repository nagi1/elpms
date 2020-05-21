<?php

namespace App\Actions\Subscription;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class UpdateSubscriptionAction
{
    protected SubscribeAction $subscribeAction;
    protected UnsubscribeAction $unsubscribeAction;

    public function __construct(SubscribeAction $subscribeAction, UnsubscribeAction $unsubscribeAction)
    {
        $this->subscribeAction = $subscribeAction;
        $this->unsubscribeAction = $unsubscribeAction;
    }


    public function execute(Model $model, Collection $users, bool $notifyNewPeople = false): void
    {
        $subscribedProjectUsers = $model->load('project.subscribers')->project->subscribers;
        $this->unsubscribeAction->execute($model, $subscribedProjectUsers);
        $this->subscribeAction->execute($model, $users);

        if ($notifyNewPeople) {
            //notification
        }
    }
}
