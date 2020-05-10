<?php

namespace App\Actions\Account;

use App\Models\Account;
use App\Actions\AbstractActions\AbstractAddCategoriesTo;


class AddCategoriesToAccountAction extends AbstractAddCategoriesTo
{
    public function execute(Account $account, array $categories): void
    {
        $account->categories()->saveMany($this->normalizeCategories($categories));
    }
}
