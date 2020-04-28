<?php

namespace App\Actions\Account;

use Illuminate\Support\Collection;
use App\Models\Account;


class AddPeopleToAccountAction
{
    public function execute(Account $account, Collection $users): void
    {
        $users->each(function ($user) use ($account) {
            $account->users()->syncWithoutDetaching($user);
        });
    }
}
