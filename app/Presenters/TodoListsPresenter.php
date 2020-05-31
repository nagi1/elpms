<?php

namespace App\Presenters;

use App\Presenters\UsersPresenter;
use App\Presenters\TodoItemsPresenter;
use App\Presenters\Contracts\PreviewContract;
use App\Presenters\CommentsPresenter;
use App\Presenters\BoostsPresenter;
use App\Models\TodoList;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class TodoListsPresenter extends FlexiblePresenter implements PreviewContract
{
    public function values(): array
    {
        return [
            'modelName' => 'TodoList',
            'modelDisplayName' => fn () => $this->displayName(),
            'path' => fn () => $this->path(),
            'id' => $this->id,
            'name' => $this->name,
            'todoItemsSummary' => fn () => TodoItemsPresenter::collection($this->whenLoaded('todoItems'))->preset('summary')->get(),
            'todoItems' => fn () => TodoItemsPresenter::collection($this->whenLoaded('todoItems')),
            'trixRichText' => fn () => $this->content,
            'excerpt' => fn () => excerpt($this->content, 30),
            'archived' => fn () => shortDate($this->archived_at),
            'order' => fn () => $this->order_column,
            'color' => fn () => $this->color,
            'completedTodoItemsCount' => fn () => $this->meta->get('completed_todo_items_count', 0),
            'todoItemsCount' => fn () => $this->meta->get('todo_items_count', 0),
            'archivedCompletedTodoItemsCount' => fn () => $this->meta->get('archived_completed_todo_items_count', 0),
            'archivedTodoItemsCount' => fn () => $this->meta->get('archived_todo_items_count', 0),
            'updated_at' => fn () => shortDate($this->updated_at),
            'comments' => fn () => CommentsPresenter::collection($this->whenLoaded('comments')),
            'commentsCount' => fn () => $this->meta->get('comments_count'),
            'boosts' => fn () => BoostsPresenter::collection($this->whenLoaded('boosts')),
            'subscribers' => fn () => UsersPresenter::make($this->whenLoaded('subscribers'))->preset('avatarWithData'),
            'user' => fn () => UsersPresenter::make($this->whenLoaded('user'))->preset('avatarWithData'),
            'hillChartPoint' => fn () => $this->meta->get('hillChartPoint', false),
            'trashedAtDate' => fn () => $this->deleted_at,
            'trashed' => fn () => shortDate($this->deleted_at),
        ];
    }

    public function presetArchived()
    {
        return $this->only('modelName', 'id', 'name', 'path', 'todoItems', 'excerpt', 'todoItems', 'archivedCompletedTodoItemsCount', 'archivedTodoItemsCount');
    }

    public function presetCard()
    {
        return $this->only(['id', 'name', 'hillChartPoint', 'todoItemsSummary']);
    }

    public function presetPreviewCard()
    {
        return $this->only('id', 'name', 'completedTodoItemsCount', 'todoItemsCount', 'modelName', 'modelDisplayName', 'path', 'todoItemsSummary', 'color', 'trashedAtDate', 'trashed', 'user');
    }

    public function presetSubscribers()
    {
        return $this->only('subscribers');
    }
}
