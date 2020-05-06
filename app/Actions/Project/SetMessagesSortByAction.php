<?php

namespace App\Actions\Project;

use App\Models\Project;

class SetMessagesSortByAction
{
    public function __construct()
    {
    }

    public function execute(Project $project, $method = 'date'): void
    {
        $project->meta->set([
            'messageBoard' => ['sortBy' => $method]
        ]);
        $project->save();
    }
}
