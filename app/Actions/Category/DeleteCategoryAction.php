<?php

namespace App\Actions\Category;

use App\Models\Category;

class DeleteCategoryAction
{

    public function execute(Category $category): void
    {
        $this->emptyMessageBoardsCategoryField($category);
        $category->delete();
    }

    private function emptyMessageBoardsCategoryField(Category $category)
    {
        $category->load(['messageBoards'])->messageBoards->each(function ($messageBoard) {
            $messageBoard->update([
                'category_id' => null,
            ]);
        });
    }
}
