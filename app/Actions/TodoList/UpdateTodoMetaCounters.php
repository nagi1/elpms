<?php

namespace App\Actions\TodoList;

use App\Models\TodoList;

class UpdateTodoMetaCounters
{
    private TodoList $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList->load(['project.todoLists.todoItems', 'todoItems']);
    }

    public function execute()
    {
        $this->updateProjectCounter();
        $this->updateTodoListCounter();
    }

    private function updateTodoListCounter()
    {
        $this->todoList->meta->set([
            'todo_items_count' => $this->todoList->todoItems()->withoutArchived()->count(),
            'completed_todo_items_count' => $this->todoList->todoItems()->completed()->withoutArchived()->count(),
        ]);
        $this->todoList->save();
    }

    private function updateProjectCounter()
    {
        $project = $this->todoList->project;

        $project->meta->set([
            'todo_items_count' => $project->todoLists()->withoutArchived()->get()->reduce(function ($count, $todoList) {
                return $count + $todoList->todoItems()->withoutArchived()->count();
            }, 0),
            'completed_todo_items_count' => $project->todoLists()->withoutArchived()->get()->reduce(function ($count, $todoList) {
                return $count + $todoList->todoItems()->completed()->withoutArchived()->count();
            }, 0),
        ]);

        $project->save();
    }
}
