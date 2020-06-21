<?php

namespace App\Actions\Event;

use Spatie\QueueableAction\QueueableAction;
use App\Models\Event;

class DeleteOccurrenceEventsAction
{
    use QueueableAction;

    public function execute(Event $event)
    {
        if (!is_null($event->event_id)) {
            Event::whereIn('event_id', $event->event_id)->forceDelete();
        }

        $event->occurrences()->forceDelete();
    }
}
