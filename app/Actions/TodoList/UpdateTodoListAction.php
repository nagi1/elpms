<?php

namespace App\Actions\TodoList;

use Auth;
use App\User;
use App\Models\TodoList;
use App\Models\Project;

class UpdateTodoListAction
{
    private array $attributes;
    private TodoList $todoList;
    private User $user;

    public function __construct(TodoList $todoList, array $attributes, User $user = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $this->attributes = $attributes;
        $this->todoList = $todoList;
        $this->user = $user;
        $this->mergeUser();
    }

    public function execute(): bool
    {
        $todoList = $this->todoList
            ->update($this->attributes);

        $this->todoList->touch();

        return $todoList;
    }

    private function mergeUser()
    {
        $this->attributes = array_merge($this->attributes, ['user_id' => $this->user->id]);
    }
}
