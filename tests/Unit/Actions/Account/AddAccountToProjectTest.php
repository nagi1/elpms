<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Models\Account;

use App\Actions\Account\AddPeopleToAccountAction;

class AddAccountToProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_add_people_to_account()
    {
        $account = factory(Account::class)->create();

        $users = factory(User::class, 3)->create();

        app(AddPeopleToAccountAction::class)->execute($account, $users);

        $this->assertCount(3, $account->users);
    }
}
