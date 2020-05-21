<?php

namespace App\Actions\TodoList;

use App\Models\TodoList;

class UpdateArchivedTodoMetaCounters
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
            'archived_todo_items_count' => $this->todoList->todoItems()->onlyArchived()->count(),
            'archived_completed_todo_items_count' => $this->todoList->todoItems()->completed()->onlyArchived()->count(),
        ]);
        $this->todoList->save();
    }

    private function updateProjectCounter()
    {
        $project = $this->todoList->project;

        $project->meta->set([
            'archived_todo_items_count' => $project->todoLists()->onlyArchived()->get()->reduce(function ($count, $todoList) {
                return $count + $todoList->todoItems()->onlyArchived()->count();
            }, 0),
            'archived_completed_todo_items_count' => $project->todoLists()->onlyArchived()->get()->reduce(function ($count, $todoList) {
                return $count + $todoList->todoItems()->completed()->onlyArchived()->count();
            }, 0),
        ]);

        $project->save();
    }
}
