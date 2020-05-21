<?php

namespace App\Actions\Project;

use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Account;

use App\Actions\Subscription\SubscribeAction;
use App\Actions\Project\SetMessagesSortByAction;
use App\Actions\Project\AddPeopleToProjectAction;

class CreateProjectAction
{
    public function execute(Account $account, array $data, Collection $users): Project
    {
        $project = $account->projects()->save(new Project(
            [
                'name' => $data['name'],
                'type' => $data['type'],
            ]
        ));

        app(SetMessagesSortByAction::class)->execute($project);
        app(AddPeopleToProjectAction::class)->execute($project, $users);
        app(AddCategoriesToProjectAction::class)->execute($project, $account->categories->all());
        app(SubscribeAction::class)->execute($project, $users);
        return $project;
    }
}
