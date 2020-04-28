<?php

namespace App\Presenters;

use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class ProjectsPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type->name(),
            'pinned' => (bool) $this->pinned,
            'users' => $this->lazy($this->users->pluck('name')),
            'categories' => $this->lazy(CategoriesPresenter::collection($this->categories)),
        ];
    }
}
