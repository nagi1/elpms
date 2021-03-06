<?php

namespace App\Actions\Account;

use App\Models\Category;
use App\Models\Account;
use App\Actions\Account\AddCategoriesToAccountAction;

class CreateAccountAction
{
    private AddCategoriesToAccountAction $addCategoriesToAccountAction;

    public function __construct(AddCategoriesToAccountAction $addCategoriesToAccountAction)
    {
        $this->addCategoriesToAccountAction = $addCategoriesToAccountAction;
    }

    public function execute(array $attributes, array $categories = []): Account
    {
        $account = Account::create($attributes);

        if (empty($categories)) {
            $categories = $this->defaultCategories();
        }


        $this->addCategoriesToAccountAction->execute($account, $categories);

        return $account;
    }

    private function defaultCategories(): array
    {
        return [
            new Category(['icon' => '😂', 'name' => 'AC1']),
            new Category(['icon' => ':heart:', 'name' => 'AC2']),
            new Category(['icon' => ':microphone:', 'name' => 'AC3']),
        ];
    }
}
