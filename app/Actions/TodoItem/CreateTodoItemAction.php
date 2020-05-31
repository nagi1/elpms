<?php

namespace App\Actions\TodoItem;


use App\User;
use App\Presenters\TodoItemsPresenter;
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

        $this->logActivity($todoItem);

        return $todoItem;
    }

    private function logActivity($todoItem)
    {
        activity("project-{$this->todoList->project_id}")
            ->performedOn($todoItem)
            ->causedBy($this->user)
            ->withProperties(['action' => 'CreateTodoItem', 'data' => TodoItemsPresenter::make($todoItem->load(['trixRichText', 'assignedTo.media']))->preset('summary')->get()])
            ->log('On :subject.todoList.name :causer.name added a new todo called :subject.description');
    }
}
