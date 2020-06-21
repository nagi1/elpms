<?php

namespace App\Presenters;

use Carbon\Carbon;
use App\User;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class TodoItemsPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'modelName' => 'TodoItem',
            'modelDisplayName' => fn () => $this->displayName(),
            'path' => fn () => $this->path(),
            'id' => $this->id,
            'description' => $this->description,
            'completed' => fn () => shortDate($this->completed_at),
            'todoList' => fn () => TodoListsPresenter::make($this->whenLoaded('todoList'))->only('id', 'name', 'path'),
            'startsAt' => fn () => $this->formatDate($this->starts_at),
            'endsAt' => fn () => $this->formatDate($this->ends_at),
            'startsAtDate' => fn () => optional($this->starts_at)->format('Y-m-d'),
            'endsAtDate' => fn () => optional($this->ends_at)->format('Y-m-d'),
            'trixRichText' => fn () => $this->content,
            'excerpt' => fn () => excerpt($this->content, 30),
            'archived' => fn () => shortDate($this->archived_at),
            'order' => fn () => $this->order_column,
            'assignedTo' => fn () => UsersPresenter::collection($this->whenLoaded('assignedTo')),
            'whenDoneNotify' => fn () => UsersPresenter::collection($this->whenLoaded('notifiedWhenDone')),
            'updated_at' => fn () => shortDate($this->updated_at),
            'comments' => fn () => CommentsPresenter::collection($this->whenLoaded('comments')),
            'commentsCount' => fn () => $this->meta->get('comments_count'),
            'boosts' => fn () => BoostsPresenter::collection($this->whenLoaded('boosts')),
            'subscribers' => fn () => UsersPresenter::make($this->whenLoaded('subscribers'))->preset('avatarWithData'),
            'user' => fn () => UsersPresenter::make($this->whenLoaded('user'))->preset('avatarWithData'),
            'createdAt' => fn () => shortDate($this->created_at),
            'events' => fn () => ChangeEventPresenter::collection($this->whenLoaded('changeEvents')),
            'trashedAtDate' => fn () => $this->deleted_at,
            'trashed' => fn () => shortDate($this->deleted_at),

        ];
    }

    public function presetOnArchivedTodoList()
    {
        return $this->only('id', 'description', 'completed', 'startsAt', 'endsAt', 'startsAtDate', 'endsAtDate', 'whenDoneNotify', 'assignedTo', 'order', 'modelName', 'path');
    }


    public function presetArchive()
    {
        return $this->except('whenDoneNotify', 'trixRichText', 'todoList', 'order');
    }

    public function presetSummary()
    {
        return $this->only('id', 'description', 'completed', 'path', 'excerpt', 'endsAt', 'startsAt', 'assignedTo', 'todoList');
    }

    public function presetShow()
    {
        return $this->except('todoList', 'order', 'excerpt');
    }

    public function presetSubscribers()
    {
        return $this->only('subscribers');
    }

    public function presetPreviewCard()
    {
        return $this->only('id', 'description', 'completed', 'path', 'excerpt', 'endsAt', 'startsAt', 'assignedTo', 'todoList', 'modelName', 'modelDisplayName', 'trashed', 'trashedAtDate', 'user');
    }

    public function formatDate(?Carbon $date = null)
    {
        if (is_null($date)) {
            return;
        }

        if ($date->isCurrentYear()) {
            return $date->format('D, j M');
        }

        return $date->format('D, j M, Y');
    }
}
