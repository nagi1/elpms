<?php

namespace App\Actions\Project;

use App\Models\Project;


class PinProjectAction
{
    public function execute(Project $project, bool $state): void
    {
        $project->update([
            'pinned' => $state,
        ]);
    }
}
