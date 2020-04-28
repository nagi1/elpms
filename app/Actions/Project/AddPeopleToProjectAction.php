<?php

namespace App\Actions\Project;

use Illuminate\Support\Collection;
use App\Models\Project;
use App\Actions\Account\AddPeopleToAccountAction;

class AddPeopleToProjectAction
{
    public function execute(Project $project, Collection $users): void
    {
        $users->each(function ($user) use ($project) {
            $project->users()->syncWithoutDetaching($user);
            (new AddPeopleToAccountAction)->execute($project->account, collect([$user]));
        });
    }
}
