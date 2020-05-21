<?php

namespace App\Http\Controllers\TodoLists;

use Inertia\Inertia;
use App\Presenters\TodoListsPresenter;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;

class TodoListsArchiveIndexController extends Controller
{

    public function __invoke(Account $account, Project $project)
    {

        return Inertia::render('TodoLists/Archive', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project)->preset('basic')->get(),
            'todoLists' => TodoListsPresenter::collection($project->todoLists()->with(['trixRichText', 'todoItems' => function ($query) {
                return $query->orderedByUncompleted()->ordered();
            }, 'todoItems.assignedTo.media', 'todoItems.notifiedWhenDone.media'])->onlyArchived()->orderByArchived()->get())->preset('archived')->get(),
        ]);
    }
}
