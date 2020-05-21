<?php

namespace App\Actions\TodoItem;

use Auth;
use App\User;
use App\Models\TodoItem;

class MarkTodoItemAction
{

    public function execute(TodoItem $todoItem, bool $mark, ?User $user = null): void
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        if ($mark) {
            $todoItem->markAsComplete();
            $todoItem->userDid([
                'type' => 'TodoCompleted',
                'content' => "{$user->name} completed this to-do"
            ], $user);
            return;
        }

        $todoItem->markAsUncompleted();
        $todoItem->userDid([
            'type' => 'TodoReopened',
            'content' => "{$user->name} re‑opened this to-do"
        ], $user);
    }
}
