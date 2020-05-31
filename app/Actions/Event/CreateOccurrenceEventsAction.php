<?php

namespace App\Actions\Event;

use Spatie\QueueableAction\QueueableAction;
use Recurr\Rule;
use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Event;

class CreateOccurrenceEventsAction
{
    use QueueableAction;

    public function execute(Project $project, Event $event, array $attributes): Collection
    {
        $occurrenceEvents = $this->prepareOccurrenceEvents($event)->map(function ($occurrence) use ($attributes, $project) {
            return $project->events()->create(array_merge(
                $attributes['input'],
                $occurrence,
            ));
        });


        $occurrenceEvents->each(function ($event) use ($attributes) {
            $event->assignTo($attributes['assignedTo']);
        });

        return $occurrenceEvents;
    }

    private function prepareOccurrenceEvents(Event $event): Collection
    {
        if (empty($event->occurrence)) {
            return collect();
        }

        return collect(ruleToEvents($event->occurrence)->map(function ($date) use ($event) {
            return [
                'event_id' => $event->id,
                'starts_at' => $date->getStart(),
                'ends_at' => $date->getEnd(),
                'user_id' => $event->user_id,
            ];
        })->toArray());
    }
}
