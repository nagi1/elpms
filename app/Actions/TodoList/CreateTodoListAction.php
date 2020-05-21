<?php

namespace App\Actions\TodoList;

use Auth;
use App\User;
use App\Models\TodoList;
use App\Models\Project;

class CreateTodoListAction
{
    private array $attributes;
    private Project $project;
    private User $user;

    public function __construct(Project $project, array $attributes, User $user = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $this->attributes = $attributes;
        $this->project = $project;
        $this->user = $user;
        $this->mergeUser();
    }

    public function execute(): TodoList
    {
        $todoList = $this->project
            ->todoLists()
            ->save(new TodoList($this->attributes));

        return $todoList;
    }

    private function mergeUser()
    {
        $this->attributes = array_merge($this->attributes, ['user_id' => $this->user->id]);
    }
}
