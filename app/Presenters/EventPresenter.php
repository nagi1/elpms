<?php

namespace App\Presenters;

use Recurr\Rule;
use Carbon\Carbon;
use App\User;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class EventPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'modelName' => 'Event',
            'modelDisplayName' => fn () => $this->displayName(),
            'path' => fn () => $this->path(),
            'id' => $this->id,
            'name' => $this->name,
            'occurrence' => fn () => $this->occurrence,
            'occurrenceEvents' => fn () => EventPresenter::collection($this->whenLoaded('occurrences'))->preset('calendarOccurrence'),
            'parentEvent' => fn () => EventPresenter::make($this->whenLoaded('parentEvent')),
            'parentEventId' => fn () => $this->event_id,
            'color' => fn () => $this->color,
            'allDay' => fn () => strToBool($this->all_day),
            'startsAt' => fn () => $this->starts_at->format('M j, Y g:ia'),
            'endsAt' => fn () => $this->ends_at->format('M j, Y g:ia'),
            'startsAtDatetime' => fn () => optional($this->starts_at)->format('Y-m-d h:m:s'),
            'endsAtDatetime' => fn () => optional($this->ends_at)->format('Y-m-d h:m:s'),
            'trixRichText' => fn () => optional($this->content),
            'excerpt' => fn () => excerpt($this->content, 30),
            'archived' => fn () => shortDate($this->archived_at),
            'assignedTo' => fn () => UsersPresenter::collection($this->whenLoaded('assignedTo'))->preset('avatarWithData'),
            'updated_at' => fn () => shortDate($this->updated_at),
            'comments' => fn () => CommentsPresenter::collection($this->whenLoaded('comments')),
            'commentsCount' => fn () => $this->meta->get('comments_count'),
            'boosts' => fn () => BoostsPresenter::collection($this->whenLoaded('boosts')),
            'subscribers' => fn () => UsersPresenter::make($this->whenLoaded('subscribers'))->preset('avatarWithData'),
            'user' => fn () => UsersPresenter::make($this->whenLoaded('user'))->preset('avatarWithData'),
            'createdAt' => fn () => shortDate($this->created_at),
            'changeEvents' => fn () => ChangeEventPresenter::collection($this->whenLoaded('changeEvents')),
            'trashedAtDate' => fn () => $this->deleted_at,
            'trashed' => fn () => shortDate($this->deleted_at),
        ];
    }

    public function presetCalendarOccurrence()
    {
        return $this->only('modelName', 'modelDisplayName', 'path', 'id', 'name', 'assignedTo', 'startsAt', 'endsAt', 'startsAtDatetime', 'endsAtDatetime', 'color')->appends([
            'path' => 'occurrencePath'
        ]);
    }


    public function presetCalendar()
    {
        return $this->only('modelName', 'modelDisplayName', 'path', 'id', 'name', 'assignedTo', 'occurrence', 'startsAt', 'endsAt', 'startsAtDatetime', 'endsAtDatetime', 'color', 'parentEventId');
    }

    public function presetSubscribers()
    {
        return $this->only('subscribers');
    }
}
