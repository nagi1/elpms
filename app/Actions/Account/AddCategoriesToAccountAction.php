<?php

namespace App\Actions\Account;

use App\Models\Account;
use App\Actions\AddCategoriesTo;


class AddCategoriesToAccountAction extends AddCategoriesTo
{
    private Account $account;
    private array $categories;

    public function __construct(Account $account, array $categories)
    {
        $this->account = $account;
        $this->categories = $this->normalizeCategories($categories);
    }

    public function execute(): void
    {
        $this->account->categories()->saveMany($this->categories);
    }
}
