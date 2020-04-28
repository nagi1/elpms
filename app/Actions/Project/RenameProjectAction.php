<?php

namespace App\Actions\Project;

use App\Models\Project;

class RenameProjectAction
{
    public function execute(string $name, Project $project): bool
    {
        return $project->update([
            'name' => $name
        ]);
    }
}
