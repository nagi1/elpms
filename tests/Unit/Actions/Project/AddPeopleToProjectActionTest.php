<?php

namespace Tests\Unit\Actions\Project;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Models\Project;
use App\Models\Account;
use App\Actions\Project\AddPeopleToProjectAction;

class AddPeopleToProjectActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_add_people_to_project()
    {
        $project = factory(Project::class)->create();
        $users = factory(User::class, 3)->create();

        app(AddPeopleToProjectAction::class)->execute($project, $users);

        $this->assertCount(3, $project->fresh()->users);
    }

    /** @test */
    public function it_add_same_people_who_added_to_the_project_to_parent_account()
    {
        $account = factory(Account::class)->create();
        $project = factory(Project::class)->create([
            'account_id' => $account->id
        ]);
        $users = factory(User::class, 3)->create();

        app(AddPeopleToProjectAction::class)->execute($project, $users);
        $projectUsers = $project->fresh()->users->pluck('id');
        $accountUsers = $account->fresh()->users->pluck('id');

        $this->assertCount(3, $projectUsers);
        $this->assertCount(3, $accountUsers);
        $this->assertEquals($projectUsers, $accountUsers);
    }
}
