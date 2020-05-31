<?php

namespace App\Actions\Event;


use Auth;
use App\User;
use App\Models\Project;
use App\Models\Event;
use App\Actions\Subscription\SubscribeAction;
use App\Actions\Event\PrepareEventAttributesAction;

class CreateEventAction
{
    private $prepareAction;
    private $occurrenceEvents;

    public function __construct(PrepareEventAttributesAction $prepareAction, CreateOccurrenceEventsAction $occurrenceEvents)
    {
        $this->prepareAction = $prepareAction;
        $this->occurrenceEvents = $occurrenceEvents;
    }

    public function execute(Project $project, array $attributes, User $user = null): Event
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $eventData = $this->prepareAction->execute($attributes);

        $event = $project->events()->create(array_merge($eventData['input'], [
            'user_id' => $user->id,
        ]));

        $event->assignTo($eventData['assignedTo']);


        if (!empty($eventData['notifiedUsers'])) {
            app(SubscribeAction::class)->execute($event, $eventData['notifiedUsers']);
        }

        $this->occurrenceEvents->onQueue()->execute($project, $event, $eventData);

        $this->logActivity($event);

        return $event;
    }



    private function logActivity($event)
    {
        // activity("project-{$event->project_id}")
        //     ->performedOn($event)
        //     ->causedBy($event->user_id)
        //     ->withProperties(['action' => 'CreateEvent', 'data' => TodoItemsPresenter::make($todoItem->load(['trixRichText', 'assignedTo.media']))->preset('summary')->get()])
        //     ->log('On :subject.todoList.name :causer.name added a new todo called :subject.description');
    }
}
