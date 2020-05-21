<?php

use Illuminate\Database\Seeder;
use App\User;
use App\States\Project\Team;
use App\States\Project\Project as ProjectProject;
use App\States\Project\Hq;
use App\Actions\User\CreateUserAction;
use App\Actions\Project\CreateProjectAction;
use App\Actions\Account\CreateAccountAction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(CreateUserAction $createUserAction)
    {
        // $this->call(UserSeeder::class);
        $user = $createUserAction->execute(factory(User::class)->raw([
            'email' => 'test@gmail.com',
        ]));


        $user2 = $createUserAction->execute(factory(User::class)->raw());

        /** @var App\Models\Account */
        $account = app(CreateAccountAction::class)->execute(['name' => 'Test Account']);

        $hq = app(CreateProjectAction::class)->execute($account, [
            'name' => "{$account->name} HQ",
            'type' => Hq::class
        ], collect([$user, $user2]));

        $team = app(CreateProjectAction::class)->execute($account, [
            'name' => "Team",
            'type' => Team::class
        ], collect([$user, $user2]));

        $project = app(CreateProjectAction::class)->execute($account, [
            'name' => "Project",
            'type' => ProjectProject::class
        ], collect([$user, $user2]));
    }
}
