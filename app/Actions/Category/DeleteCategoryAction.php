<?php

namespace App\Actions\Category;

use App\Models\Category;

class DeleteCategoryAction
{
    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function execute(): void
    {
        $this->emptyMessageBoardsCategory();
        $this->category->delete();
    }

    private function emptyMessageBoardsCategory()
    {
        $this->category->messageBoards->each(function ($messageBoard) {
            $messageBoard->update([
                'category_id' => null,
            ]);
        });
    }
}
