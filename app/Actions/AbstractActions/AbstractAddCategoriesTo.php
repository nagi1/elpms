<?php

namespace App\Actions\AbstractActions;

use App\Models\Category;

abstract class AbstractAddCategoriesTo
{
    protected function normalizeCategories(array $categories): array
    {
        return collect($categories)->map(function ($category) {
            if ($category instanceof Category) {
                return new Category([
                    'name' => $category->name,
                    'icon' => $category->icon
                ]);
            }

            return new Category([
                'name' => $category['name'],
                'icon' => $category['icon']
            ]);
        })->all();
    }
}
