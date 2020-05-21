<?php

namespace App\Actions\TodoItem;


use App\User;
use App\Models\TodoList;
use App\Models\TodoItem;
use App\Actions\TodoList\UpdateTodoMetaCounters;
use App\Actions\TodoList\UpdateArchivedTodoMetaCounters;
use App\Actions\Subscription\SubscribeAction;

class CreateTodoItemAction extends AbstractTodoItemAction
{
    private TodoList $todoList;

    public function __construct(TodoList $todoList, array $attributes, User $user = null)
    {
        parent::__construct($attributes, $user);

        $this->todoList = $todoList;
        $this->prepareAttributes();
    }

    public function execute(): TodoItem
    {
        $todoItem = $this->todoList
            ->todoItems()
            ->save(new TodoItem($this->preparedAttributes));

        $todoItem->assignTo($this->prepareUsers($this->attributes['assignedTo']));
        $todoItem->whenDoneNotify($this->prepareUsers($this->attributes['whenDoneNotify']));

        if ($this->attributes['notifyAssignedUsers']) {
            app(SubscribeAction::class)->execute($todoItem, $this->prepareUsers($this->attributes['assignedTo']));
        }

        (new UpdateTodoMetaCounters($this->todoList))->execute();
        (new UpdateArchivedTodoMetaCounters($this->todoList))->execute();

        return $todoItem;
    }
}
