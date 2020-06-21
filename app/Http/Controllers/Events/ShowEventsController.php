<?php

namespace App\Http\Controllers\Events;

use Inertia\Inertia;
use App\Presenters\ProjectsPresenter;
use App\Presenters\EventPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Event;
use App\Models\Comment;
use App\Models\Account;
use App\Http\Controllers\Controller;

class ShowEventsController extends Controller
{
    public function __invoke(Account $account, Project $project, Event $event)
    {
        // dd(EventPresenter::make($event->load(['trixRichText', 'user.media', 'assignedTo.media', 'comments.user.media', 'comments.boosts.user.media', 'comments.trixRichText', 'boosts.user.media', 'subscribers.media', 'changeEvents.user.media', 'changeEvents.boosts']))->preset('show')->get());
        return Inertia::render('Events/Show', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load(['users.media']))->only('id', 'name', 'users')->get(),
            'event' => EventPresenter::make($event->load(['trixRichText', 'user.media', 'assignedTo.media', 'comments.user.media', 'comments.boosts.user.media', 'comments.trixRichText', 'boosts.user.media', 'subscribers.media', 'changeEvents.user.media', 'changeEvents.boosts']))->preset('show')->get(),
            'commentsTrix' => trixEditorForModel(Comment::class),
            'eventTrix' => trixEditorForModel(Event::class),
        ]);
    }
}
