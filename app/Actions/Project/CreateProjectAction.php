<?php

namespace App\Actions\Project;

use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Category;
use App\Models\Account;
use App\Actions\Project\AddPeopleToProjectAction;

class CreateProjectAction
{

    public function execute(Account $account, array $data, Collection $users): Project
    {
        $project = $account->projects()->save(new Project(
            [
                'name' => $data['name'],
                'type' => $data['type']
            ]
        ));

        (new AddPeopleToProjectAction)->execute($project, $users);
        (new AddCategoriesToProjectAction)->execute($project, $this->normalizeCategories($account->categories));
        return $project;
    }

    private function normalizeCategories(Collection $categories): array
    {
        return $categories->map(function ($category) {
            return new Category([
                'icon' => $category->icon,
                'name' => $category->name
            ]);
        })->all();
    }
}
