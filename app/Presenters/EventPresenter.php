<?php

namespace App\Presenters;

use Recurr\Transformer\TextTransformer;
use Recurr\Rule;
use Carbon\Carbon;
use App\User;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class EventPresenter extends FlexiblePresenter
{
    public $rule;

    public function values(): array
    {

        $this->rule = (new Rule)->createFromString($this->occurrence);

        return [
            'modelName' => 'Event',
            'modelDisplayName' => fn () => $this->displayName(),
            'path' => fn () => $this->path(),
            'id' => $this->id,
            'name' => $this->name,
            'occurrence' => fn () => $this->occurrence,
            'occurrenceText' => fn () => empty($this->occurrence) ? 'No occurrence' : ucfirst($this->getOccurrenceText()),
            'repeatSettings' => fn () => [
                'repeat' => $this->getRepeatValue(),
                'repeatPeriod' => is_null($this->rule->getUntil()) ? 'forever' : 'until',
                'repeatUntil' =>  optional($this->rule->getUntil())->format('Y-m-d')
            ],
            'occurrenceEvents' => fn () => EventPresenter::collection($this->whenLoaded('occurrences'))->preset('calendarOccurrence'),
            'parentEvent' => fn () => EventPresenter::make($this->whenLoaded('parentEvent')),
            'parentEventId' => fn () => $this->event_id,
            'color' => fn () => $this->color,
            'allDay' => fn () => strToBool($this->all_day),
            'startsAt' => fn () => $this->starts_at->format('M j, Y g:ia'),
            'endsAt' => fn () => $this->ends_at->format('M j, Y g:ia'),
            'readableDiff' => fn () => $this->getReadableDiff(),
            'startsAtDatetime' => fn () => optional($this->starts_at)->format('Y-m-d h:m:s'),
            'endsAtDatetime' => fn () => optional($this->ends_at)->format('Y-m-d h:m:s'),
            'singleView' => fn () => [
                'start' => [
                    'day' => $this->starts_at->format('d'),
                    'month' => $this->starts_at->format('M')
                ],
                'end' => [
                    'day' => $this->ends_at->format('j'),
                    'month' => $this->ends_at->format('M')
                ]
            ],
            'trixRichText' => fn () => $this->content,
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

    public function getReadableDiff()
    {
        if ($this->starts_at->isPast() && $this->ends_at->isFuture()) {
            return "Happening now";
        }

        if ($this->starts_at->isPast()) {
            return "Finished {$this->ends_at->diffForHumans()}";
        }

        return "{$this->starts_at->diffForHumans()}";
    }
    public function presetCalendarOccurrence()
    {
        return $this->only('modelName', 'modelDisplayName', 'path', 'id', 'name', 'assignedTo', 'startsAt', 'endsAt', 'startsAtDatetime', 'endsAtDatetime', 'color')->appends([
            'path' => 'occurrencePath'
        ]);
    }

    private function getRepeatValue()
    {

        if (empty($this->occurrence)) {
            return "no";
        } else if ($this->rule->getFreqAsText() == "DAILY" && $this->rule->getInterval() == 2) {
            return "otherDay";
        } else if ($this->rule->getFreqAsText() == "WEEKLY" && $this->rule->getInterval() == 2) {
            return "otherWeek";
        } else if ($this->rule->getFreqAsText() == "WEEKLY" && $this->rule->getByDay() === ['FR', 'SA']) {
            return "weekend";
        } else if ($this->rule->getFreqAsText() == "WEEKLY" && $this->rule->getByDay() === ['SU', 'MO', 'TU', 'WE', 'TH']) {
            return "weekday";
        } else {
            return $this->rule->getFreqAsText();
        }
    }

    public function getOccurrenceText(): string
    {
        $textTransformer = new TextTransformer();
        return $textTransformer->transform((new Rule)->createFromString($this->occurrence, $this->starts_at, $this->ends_at));
    }

    public function presetShow()
    {
        return $this->except('occurrenceEvents', 'excerpt', 'parentEvent');
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
