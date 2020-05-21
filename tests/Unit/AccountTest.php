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
use App\Models\TodoList;
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
    }
}
