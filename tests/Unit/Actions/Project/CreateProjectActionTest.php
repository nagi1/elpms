<?php

namespace Tests\Unit\Actions\Project;



use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Models\TodoList;
use App\Models\Pivots\Assignable;
use App\Actions\Project\CreateProjectAction;
use App\Actions\Account\CreateAccountAction;

class CreateProjectActionTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function it_create_project_with_all_associate_actions()
    {
        app(CreateAccountAction::class)->execute([
            'name' => 'Test Account'
        ]);

        $this->assertDatabaseHas('accounts', [
            'name' => 'Test Account'
        ]);
    }

    /** @test */
    public function it_create_account_and_associate_default_categories_to_it()
    {
        $category = [['name' => 'test category', 'icon' => ':smile:']];
        $account = app(CreateAccountAction::class)->execute(['name' => 'Test account'], $category);
        $users = factory(User::class, 3)->create();
        $projectAttributes = [
            'name' => 'Test project',
            'type' => 'team',
        ];
        $project = app(CreateProjectAction::class)->execute($account, $projectAttributes, $users);
        $todoList =  $project->todoLists()->save(new TodoList(['name' => 'name', 'user_id' => $users->first()->id]));

        $todoList->whenDoneNotify($users);
        dd($todoList->notifiedWhenDone()->first()->assignable);

        $this->assertDatabaseHas('projects', $projectAttributes);
        $this->assertEquals(['sortBy' => 'created_at'], $project->meta->messageBoard);
        $this->assertEquals($project->users->pluck('id'), $users->pluck('id'));
        $this->assertEquals($category[0]['name'], $project->categories()->first()->name);
        $this->assertCount(3, $project->subscribers);
    }
}
