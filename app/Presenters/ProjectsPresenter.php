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
            'MessageBoardMeta' => $this->lazy($this->meta->get('messageBoard')),
            'users' => $this->lazy(UsersPresenter::collection($this->whenLoaded('users'))->preset('avatarWithData')),
            'categories' => $this->lazy(CategoriesPresenter::collection($this->whenLoaded('categories'))->except('project_id')),
            'subscribers' => $this->lazy(UsersPresenter::make($this->whenLoaded('subscribers'))->preset('avatarWithData')),
        ];
    }

    public function presetBasic()
    {
        return $this->only('id', 'name', 'type');
    }
}
