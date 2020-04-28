<?php

namespace App\Actions\Project;

use App\Models\Project;

class PinProjectAction
{
    public function execute(bool $pinState, Project $project): bool
    {
        return $project->update([
            'pinned' => $pinState,
        ]);
    }
}
