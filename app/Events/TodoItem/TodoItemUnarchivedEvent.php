<?php

namespace App\Events\TodoItem;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\TodoItem;
use App\Actions\TodoList\UpdateTodoMetaCounters;
use App\Actions\TodoList\UpdateArchivedTodoMetaCounters;

class TodoItemUnarchivedEvent
{
    use Dispatchable, SerializesModels;

    private TodoItem $todoItem;

    public function __construct(TodoItem $todoItem)
    {
        $this->todoItem = $todoItem;
        $this->handle();
    }

    public function handle()
    {
        (new UpdateArchivedTodoMetaCounters($this->todoItem->todoList))->execute();
        (new UpdateTodoMetaCounters($this->todoItem->todoList))->execute();
    }
}
