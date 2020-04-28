<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\States\Project\Project as ProjectProject;
use App\Models\Project;
use App\Models\Account;

class AccountTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_can_join_an_account()
    {
        $account = factory(Account::class)->create();
        $user = factory(User::class)->create();
        $project = Project::create([
            'type' => ProjectProject::class,
            'name' => 'Project',
            'account_id' => $account->id,
        ]);

        $account->users()->attach($user);

        $project->users()->attach($user);

        dd($user->projects);
    }
}
