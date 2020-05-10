<?php

namespace App\Actions\Project;

use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Account;
use App\Actions\Subscribable\SubscribeAction;
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

        (new SetMessagesSortByAction)->execute($project);
        (new AddPeopleToProjectAction($project, $users))->execute();
        (new AddCategoriesToProjectAction($project, $account->categories->all()))->execute();
        (new SubscribeAction)->execute($project, $users);
        return $project;
    }
}
