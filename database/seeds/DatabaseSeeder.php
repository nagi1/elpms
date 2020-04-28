<?php

use Illuminate\Database\Seeder;
use App\User;
use App\States\Project\Team;
use App\States\Project\Project as ProjectProject;
use App\States\Project\Hq;
use App\Models\Project;
use App\Models\Account;
use App\Actions\Project\CreateProjectAction;
use App\Actions\Project\AddPeopleToProjectAction;
use App\Actions\Account\CreateAccountAction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $user = factory(User::class)->create([
            'email' => 'test@gmail.com',
        ]);
        $user2 = factory(User::class)->create();

        /** @var App\Models\Account */
        $account = (new CreateAccountAction(['name' => 'Test Account']))->execute();

        $hq = (new CreateProjectAction)->execute($account, [
            'name' => "{$account->name} HQ",
            'type' => Hq::class
        ], collect([$user]));

        $team = (new CreateProjectAction)->execute($account, [
            'name' => "Team",
            'type' => Team::class
        ], collect([$user]));

        $project = (new CreateProjectAction)->execute($account, [
            'name' => "Project",
            'type' => ProjectProject::class
        ], collect([$user2, $user]));
    }
}
