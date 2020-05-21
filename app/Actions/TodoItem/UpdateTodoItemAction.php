<?php

namespace App\Actions\TodoItem;


use App\User;
use App\Models\TodoList;
use App\Models\TodoItem;
use App\Actions\Subscription\SubscribeAction;

class UpdateTodoItemAction extends AbstractTodoItemAction
{
    private TodoItem $todoItem;

    public function __construct(TodoItem $todoItem, array $attributes, User $user = null)
    {
        parent::__construct($attributes, $user);

        $this->todoItem = $todoItem;
        $this->prepareAttributes();
    }

    public function execute(): bool
    {
        $update = $this->todoItem
            ->update($this->preparedAttributes);

        $this->todoItem->assignTo($this->prepareUsers($this->attributes['assignedTo']));
        $this->todoItem->whenDoneNotify($this->prepareUsers($this->attributes['whenDoneNotify']));

        if ($this->attributes['notifyAssignedUsers']) {
            app(SubscribeAction::class)->execute($this->todoItem, $this->prepareUsers($this->attributes['assignedTo']));
        }

        return $update;
    }
}
