<?php

namespace Tests\Unit;

use Tests\TestCase;
use ReflectionClass;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\States\Status\Archived;
use App\States\Project\Project as ProjectProject;
use App\Models\Project;
use App\Models\Concerns\Commentable;
use App\Models\Account;
use App\Actions\User\CreateUserAction;
use App\Actions\Project\CreateProjectAction;
use App\Actions\MessageBoard\CreateMessageBoardAction;
use App\Actions\Account\CreateAccountAction;

class AccountTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_can_join_an_account()
    {
        $createUserAction = app(CreateUserAction::class);
        $user = $createUserAction->execute(factory(User::class)->raw([
            'email' => 'test@gmail.com',
        ]));

        $this->actingAs($user);
        $account = (new CreateAccountAction([
            'name' => 'Account'
        ]))->execute();

        $project = (new CreateProjectAction($account, [
            'name' => 'project',
            'type' => 'team'
        ], collect([$user])))->execute();

        $message = (new CreateMessageBoardAction($project, [
            'title' => 'some title'
        ]))->execute();


        $message->status->transitionTo(Archived::class);

        dd($message);
    }
}
