<?php

namespace App\Actions\HillChart;

use Illuminate\Support\Collection;
use App\Models\TodoList;
use App\Models\Project;

class EnableHillChartAction
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(Project $project, Collection $selectedTodoLists)
    {
        $project->todoLists->filter(function (TodoList $todoList) use ($selectedTodoLists) {
            return !$selectedTodoLists->contains($todoList);
        })->each(function (TodoList $todoList) {
            $todoList->disableHillChartPoint();
        });

        if (count($selectedTodoLists) > 0) {
            $selectedTodoLists->each(function (TodoList $todoList) {
                $todoList->hasBeenEnabled() ? $todoList->enableHillChartPoint() : $todoList->setHillChartPoint();
            });

            $project->toggleHillChart(true);
            return true;
        }

        $project->toggleHillChart(false);
        return false;
    }
}
