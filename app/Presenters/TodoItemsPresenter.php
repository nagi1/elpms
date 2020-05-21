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
            'modelDisplayName' => $this->displayName(),
            'path' => $this->path(),
            'id' => $this->id,
            'description' => $this->description,
            'completed' => shortDate($this->completed_at),
            'todoList' => $this->lazy(['id' => $this->todo_list_id]),
            'startsAt' => $this->formatDate($this->starts_at),
            'endsAt' => $this->formatDate($this->ends_at),
            'startsAtDate' => optional($this->starts_at)->format('Y-m-d'),
            'endsAtDate' => optional($this->ends_at)->format('Y-m-d'),
            'trixRichText' => $this->lazy(optional($this->trixRichText->first())->content),
            'excerpt' => $this->lazy(excerpt(optional($this->trixRichText->first())->content, 30)),
            'archived' => shortDate($this->archived_at),
            'order' => $this->order_column,
            'assignedTo' => $this->lazy(UsersPresenter::collection($this->whenLoaded('assignedTo'))),
            'whenDoneNotify' => $this->lazy(UsersPresenter::collection($this->whenLoaded('notifiedWhenDone'))),
            'updated_at' => $this->lazy(shortDate($this->updated_at)),
            'comments' => $this->lazy(CommentsPresenter::collection($this->whenLoaded('comments'))),
            'commentsCount' => $this->lazy($this->meta->get('comments_count')),
            'boosts' => $this->lazy(BoostsPresenter::collection($this->whenLoaded('boosts'))),
            'subscribers' => $this->lazy(UsersPresenter::make($this->whenLoaded('subscribers'))->preset('avatarWithData')),
            'user' => $this->lazy(UsersPresenter::make($this->whenLoaded('user'))->preset('avatarWithData')),
            'createdAt' => $this->lazy(shortDate($this->created_at)),
            'events' => $this->lazy(EventPresenter::collection($this->whenLoaded('events'))),

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

    public function presetShow()
    {
        return $this->except('todoList', 'order', 'excerpt');
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
