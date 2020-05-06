<?php

namespace App\Actions\Project;

use Illuminate\Support\Collection;
use App\Models\Project;
use App\Actions\Account\AddPeopleToAccountAction;

class AddPeopleToProjectAction
{
    private Project $project;
    private Collection $users;

    public function __construct(Project $project, Collection $users)
    {
        $this->project = $project;
        $this->users = $users;
    }

    public function execute(): void
    {
        $this->users->each(function ($user) {
            $this->project->users()->syncWithoutDetaching($user);
            (new AddPeopleToAccountAction($this->project->account, collect([$user])))->execute();
        });
    }
}
