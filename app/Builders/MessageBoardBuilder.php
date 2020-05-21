<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\States\MessageBoard\Published;
use App\States\MessageBoard\Draft;


class MessageBoardBuilder extends Builder
{
    public $sortByOptions = [
        'created_at' => 'desc',
        'updated_at' => 'desc',
        'title' => 'asc',
    ];

    public function published(): Builder
    {
        $this->whereState('state', Published::class);
        return $this;
    }

    public function draft(): Builder
    {
        return $this->whereState('state', Draft::class);
        return $this;
    }

    public function byUser($userId): Builder
    {
        return $this->where('user_id', $userId);
        return $this;
    }


    public function whereCategory(string $category): Builder
    {
        return $this->where('category_id', $category)->limit(15);
        return $this;
    }


    private function sortByLastComment(): Builder
    {
        $this->whereHas('comments', function ($query) {
            return $query->orderByDesc('created_at');
        });

        return $this;
    }

    public function sortBy(string $sortBy): Builder
    {
        if ($sortBy == 'last_comment') {
            return $this->sortByLastComment();
        }

        $this->orderBy($sortBy, $this->sortByOptions[$sortBy]);

        return $this;
    }
}
