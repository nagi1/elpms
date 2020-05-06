<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Auth;
use App\Presenters\ProjectsPresenter;
use App\Presenters\ProjectIndexPresenter;
use App\Presenters\MessageBoardsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Account;
use App\Actions\Project\CreateProjectAction;

class ProjectsController extends Controller
{
    public function store(Account $account, Request $request)
    {
        (new CreateProjectAction($account, $request->validate([
            'name' => ['required'],
            'type' => ['required', 'in:project,team']
        ]), collect([Auth::user()])))->execute();

        return Redirect::back();
    }


    public function show(Account $account, Project $project)
    {

        return Inertia::render('Projects/Index', [
            'account' => AccountsPresenter::make($account)->preset('basic'),
            'project' => ProjectsPresenter::make($project->load('users.media'))->except('categories')->get(),
            'messageBoards' => MessageBoardsPresenter::collection($project->messageBoards()->latest()->limit(5)->with(['user.media', 'trixRichText', 'category'])->get())->preset('card')->get(),
        ]);
    }
}
