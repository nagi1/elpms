<?php

namespace App\Actions\Account;

use Illuminate\Support\Collection;
use App\Models\Account;


class AddPeopleToAccountAction
{
    private Account $account;
    private Collection $users;

    public function __construct(Account $account, Collection $users)
    {
        $this->account = $account;
        $this->users = $users;
    }

    public function execute(): void
    {
        $this->users->each(function ($user) {
            $this->account->users()->syncWithoutDetaching($user);
        });
    }
}
