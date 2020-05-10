<?php

namespace App\Actions\Project;

use Illuminate\Support\Collection;
use App\Models\Project;
use App\Actions\Account\AddPeopleToAccountAction;

class AddPeopleToProjectAction
{
    private AddPeopleToAccountAction $addPeopleToAccountAction;

    public function __construct(AddPeopleToAccountAction $addPeopleToAccountAction)
    {
        $this->addPeopleToAccountAction = $addPeopleToAccountAction;
    }

    public function execute(Project $project, Collection $users): void
    {
        $project->users()->syncWithoutDetaching($users);
        $this->addPeopleToAccountAction->execute($project->account, $users);
    }
}
