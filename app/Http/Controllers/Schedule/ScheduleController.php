<?php

namespace App\Http\Controllers\Schedule;

use Recurr\Transformer\ArrayTransformerConfig;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Presenters\ProjectsPresenter;
use App\Presenters\EventPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Event;
use App\Models\Account;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index(Account $account, Project $project)
    {
        // dd(EventPresenter::collection($project->events()->withoutArchived()->with(['assignedTo.media',])->get())->preset('calendar')->get());
        return Inertia::render('Schedule/Index', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load(['users.media', 'subscribers.media']))->only('id', 'name', 'users', 'subscribers')->get(),
            'events' => EventPresenter::collection($project->events()->withoutArchived()->with(['assignedTo.media'])->get())->preset('calendar')->get(),
            'trix' => trixEditorForModel(Event::class),
        ]);
    }
}
