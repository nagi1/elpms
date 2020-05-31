<?php

namespace App\Actions\TodoItem;

use Auth;
use App\User;
use App\Models\TodoItem;
use App\Actions\TodoList\UpdateTodoMetaCounters;
use App\Actions\TodoList\UpdateArchivedTodoMetaCounters;

class MarkTodoItemAction
{

    public function execute(TodoItem $todoItem, bool $mark, ?User $user = null): void
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        if ($mark) {
            $todoItem->update([
                'completed_at' => now()
            ]);

            $todoItem->userDid([
                'type' => 'TodoCompleted',
                'content' => "{$user->name} completed this to-do"
            ], $user);
        } else {

            $todoItem->update([
                'completed_at' => null,
            ]);

            $todoItem->userDid([
                'type' => 'TodoReopened',
                'content' => "{$user->name} re‑opened this to-do"
            ], $user);
        }

        (new UpdateTodoMetaCounters($todoItem->todoList))->execute();
        (new UpdateArchivedTodoMetaCounters($todoItem->todoList))->execute();
    }
}
