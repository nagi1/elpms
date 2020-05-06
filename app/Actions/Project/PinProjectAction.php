<?php

namespace App\Actions\Project;

use App\Models\Project;


class PinProjectAction
{

    private Project $project;
    private bool $state;

    public function __construct(Project $project, bool $state)
    {
        $this->project = $project;
        $this->state = $state;
    }

    public function execute(): void
    {
        $this->project->update([
            'pinned' => $this->state,
        ]);
    }
}
