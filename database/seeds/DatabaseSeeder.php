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
        $account = (new CreateAccountAction(['name' => 'Test Account']))->execute();

        $hq = (new CreateProjectAction($account, [
            'name' => "{$account->name} HQ",
            'type' => Hq::class
        ], collect([$user, $user2])))->execute();

        $team = (new CreateProjectAction($account, [
            'name' => "Team",
            'type' => Team::class
        ], collect([$user, $user2])))->execute();

        $project = (new CreateProjectAction($account, [
            'name' => "Project",
            'type' => ProjectProject::class
        ], collect([$user, $user2])))->execute();
    }
}
