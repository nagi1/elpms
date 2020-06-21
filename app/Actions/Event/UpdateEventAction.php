<?php

namespace App\Actions\Event;

use App\Models\Project;
use App\Models\Event;
use App\Actions\Event\PrepareEventAttributesAction;
use App\Actions\Event\CreateOccurrenceEventsAction;

class UpdateEventAction
{
    private $prepareAction;
    private $occurrenceEvents;
    private $deleteOccurrenceEvents;

    public function __construct(PrepareEventAttributesAction $prepareAction, CreateOccurrenceEventsAction $occurrenceEvents, DeleteOccurrenceEventsAction $deleteOccurrenceEvents)
    {
        $this->prepareAction = $prepareAction;
        $this->occurrenceEvents = $occurrenceEvents;
        $this->deleteOccurrenceEvents = $deleteOccurrenceEvents;
    }

    public function execute(Project $project, Event $event, array $attributes): bool
    {
        $eventData = $this->prepareAction->execute($attributes);

        $update = $event->update($eventData['input']);

        $event->assignTo($eventData['assignedTo']);

        if (strToBool($attributes['applyOnOccurrences'])) {
            $this->deleteOccurrenceEvents->onQueue()->execute($event);
            $this->occurrenceEvents->onQueue()->execute($project, $event, $eventData);
        }
        return $update;
    }
}
