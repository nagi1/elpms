<?php

namespace App\Http\Controllers\Questionnaires;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;

class QuestionnairesController extends Controller
{
    public function index()
    {
    }

    public function create(Account $account, Project $project)
    {
        return Inertia::render('Questionnaires/Create', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load(['users']))->only('id', 'name', 'categories')->get(),
        ]);
    }
}
