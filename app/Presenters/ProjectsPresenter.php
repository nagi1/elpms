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
            'MessageBoardMeta' => fn () => $this->meta->get('messageBoard'),
            'users' => fn () => UsersPresenter::collection($this->whenLoaded('users'))->preset('avatarWithData'),
            'categories' => fn () => CategoriesPresenter::collection($this->whenLoaded('categories'))->except('project_id'),
            'subscribers' => fn () => UsersPresenter::make($this->whenLoaded('subscribers'))->preset('avatarWithData'),
            'completedTodoItemsCount' => fn () => $this->meta->get('completed_todo_items_count', 0),
            'todoItemsCount' => fn () => $this->meta->get('todo_items_count', 0),
            'hillChart' => fn () => $this->meta->get('hillChart', false),
        ];
    }

    public function presetBasic()
    {
        return $this->only('id', 'name', 'type');
    }
}
