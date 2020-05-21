<?php

namespace App\Events\TodoList;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\TodoList;
use App\Models\TodoItem;
use App\Actions\TodoList\UpdateTodoMetaCounters;
use App\Actions\TodoList\UpdateArchivedTodoMetaCounters;

class TodoListUnarchivedEvent
{
    use Dispatchable, SerializesModels;

    private TodoList $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
        $this->handle();
    }

    public function handle()
    {
        $this->todoList->todoItems->each(function (TodoItem $todoItem) {
            $todoItem->unarchiveWithoutEvents();
        });

        (new UpdateArchivedTodoMetaCounters($this->todoList))->execute();
        (new UpdateTodoMetaCounters($this->todoList))->execute();
    }
}
