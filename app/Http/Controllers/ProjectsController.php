<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Auth;
use App\Presenters\ProjectsPresenter;
use App\Presenters\ProjectIndexPresenter;
use App\Models\Project;
use App\Models\Account;
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
            'account' => $account->only('id', 'name'),
            'project' => ProjectsPresenter::make($project)->only('id', 'name', 'description', 'users'),
            'buckets' => [
                'messageBoard' => []
            ],
        ]);
    }
}
