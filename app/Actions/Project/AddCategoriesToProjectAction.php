<?php

namespace App\Actions\Project;

use App\Models\Project;

class AddCategoriesToProjectAction
{
    public function execute(Project $project, array $categories): void
    {
        $project->categories()->saveMany($categories);
    }
}
