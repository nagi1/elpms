<?php

namespace App\Actions\Account;

use App\Models\Category;
use App\Models\Account;
use App\Actions\Account\AddCategoriesToAccountAction;

class CreateAccountAction
{
    private array $attributes;
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function execute(): Account
    {
        $account = Account::create($this->attributes);

        (new AddCategoriesToAccountAction)->execute($account, [
            new Category(['icon' => '😂', 'name' => 'Account category 1']),
            new Category(['icon' => '😂', 'name' => 'Account category 2']),
            new Category(['icon' => '😂', 'name' => 'Account category 3']),
        ]);

        return $account;
    }
}
