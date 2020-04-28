<?php

namespace App\Actions\Account;

use App\Models\Account;

class AddCategoriesToAccountAction
{
    public function execute(Account $account, array $categories): void
    {
        $account->categories()->saveMany($categories);
    }
}
