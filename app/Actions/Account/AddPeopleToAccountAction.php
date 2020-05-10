<?php

namespace App\Actions\Account;

use Illuminate\Support\Collection;
use App\Models\Account;

class AddPeopleToAccountAction
{

    public function execute(Account $account, Collection $users): void
    {
        $account->users()->syncWithoutDetaching($users);
    }
}
