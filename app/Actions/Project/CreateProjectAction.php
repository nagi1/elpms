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
    private Account $account;
    private array $data;
    private Collection $users;

    public function __construct(Account $account, array $data, Collection $users)
    {
        $this->account = $account;
        $this->data = $data;
        $this->users = $users;
    }


    public function execute(): Project
    {
        $project = $this->account->projects()->save(new Project(
            [
                'name' => $this->data['name'],
                'type' => $this->data['type'],
            ]
        ));

        (new SetMessagesSortByAction)->execute($project);
        (new AddPeopleToProjectAction($project, $this->users))->execute();
        (new SubscribeAction)->execute($project, $this->users);
        (new AddCategoriesToProjectAction($project, $this->account->categories->all()))->execute();
        return $project;
    }
}
