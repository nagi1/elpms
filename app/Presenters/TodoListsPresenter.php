<?php

namespace App\Presenters;

use App\Presenters\UsersPresenter;
use App\Presenters\TodoItemsPresenter;
use App\Presenters\CommentsPresenter;
use App\Presenters\BoostsPresenter;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class TodoListsPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'modelName' => 'TodoList',
            'modelDisplayName' => $this->displayName(),
            'path' => $this->path(),
            'id' => $this->id,
            'name' => $this->name,
            'todoItems' => $this->lazy(TodoItemsPresenter::collection($this->whenLoaded('todoItems'))),
            'trixRichText' => $this->lazy(optional($this->trixRichText->first())->content),
            'excerpt' => $this->lazy(excerpt(optional($this->trixRichText->first())->content, 30)),
            'archived' => shortDate($this->archived_at),
            'order' => $this->order_column,
            'completedTodoItemsCount' => $this->lazy($this->meta->get('completed_todo_items_count', 0)),
            'todoItemsCount' => $this->lazy($this->meta->get('todo_items_count', 0)),
            'archivedCompletedTodoItemsCount' => $this->lazy($this->meta->get('archived_completed_todo_items_count', 0)),
            'archivedTodoItemsCount' => $this->lazy($this->meta->get('archived_todo_items_count', 0)),
            'updated_at' => $this->lazy(shortDate($this->updated_at)),
            'comments' => $this->lazy(CommentsPresenter::collection($this->whenLoaded('comments'))),
            'commentsCount' => $this->lazy($this->meta->get('comments_count')),
            'boosts' => $this->lazy(BoostsPresenter::collection($this->whenLoaded('boosts'))),
            'subscribers' => $this->lazy(UsersPresenter::make($this->whenLoaded('subscribers'))->preset('avatarWithData')),
            'user' => $this->lazy(UsersPresenter::make($this->whenLoaded('user'))->preset('avatarWithData')),

        ];
    }

    public function presetArchived()
    {
        return $this->only('modelName', 'id', 'name', 'path', 'todoItems', 'excerpt', 'todoItems', 'archivedCompletedTodoItemsCount', 'archivedTodoItemsCount');
    }
}
