<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\States\Project\Team;
use App\States\Project\Project as ProjectProject;
use App\States\Project\Hq;
use App\Models\Project;
use App\Models\Account;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'account_id' => factory(Account::class),
        'description' => $faker->paragraph(5),
        'type' => $faker->randomElement([ProjectProject::class, Team::class])
    ];
});

$factory->state(Project::class, 'hq', ['type' => Hq::class]);
$factory->state(Project::class, 'project', ['type' => ProjectProject::class]);
$factory->state(Project::class, 'team', ['type' => Team::class]);
