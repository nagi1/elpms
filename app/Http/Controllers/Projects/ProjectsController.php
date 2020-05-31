<?php

namespace App\Http\Controllers\Projects;

use Spatie\Activitylog\Models\Activity;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Auth;
use App\Presenters\TodoListsPresenter;
use App\Presenters\TodoItemsPresenter;
use App\Presenters\ProjectsPresenter;
use App\Presenters\ProjectIndexPresenter;
use App\Presenters\MessageBoardsPresenter;
use App\Presenters\ActivitiesPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\TodoList;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Project\CreateProjectAction;

class ProjectsController extends Controller
{
    public function store(Account $account, Request $request, CreateProjectAction $createProjectAction)
    {
        $createProjectAction->execute($account, $request->validate([
            'name' => ['required'],
            'type' => ['required', 'in:project,team']
        ]), collect([Auth::user()]));

        return Redirect::back();
    }


    public function show(Account $account, Project $project)
    {
        return Inertia::render('Projects/Index', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load('users.media'))->except('categories')->get(),
            'messageBoards' => MessageBoardsPresenter::collection($project->messageBoards()->withoutArchived()->published()->latest()->limit(5)->with(['user.media', 'trixRichText', 'category'])->get())->preset('card')->get(),
            'todoLists' => TodoListsPresenter::collection($project->todoLists()->with(['todoItems.trixRichText', 'todoItems.assignedTo.media', 'todoItems.todoList'])->withoutArchived()->latest()->limit(5)->get())->preset('card')->get(),
            'activities' => ActivitiesPresenter::collection(Activity::with(['causer.media'])->inLog("project-{$project->id}")->latest()->get())->get()
        ]);
    }
}
