<?php

namespace App\Http\Controllers\Move;


use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Copyable\MoveAction;

class MoveController extends Controller
{
    public function show(Account $account, Project $project, $model, $modelId)
    {
        $model = getModelByType($model, $modelId);

        return Inertia::render('Move/Show', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project)->only('id', 'name')->get(),
            'projects' => ProjectsPresenter::collection(Auth::user()->projects)->only('id', 'name')->get(),
            'previewCard' => $model->previewCard(),
            'breadcrumbs' => [
                'index' => [
                    'link' => $model->indexPath(),
                    'text' => $model->displayName(),
                ],
                'model' => [
                    'link' => $model->path(),
                    'text' => $model->displayField()
                ]
            ]

        ]);
    }

    public function store(Account $account, Project $project, Request $request, $model, $modelId, MoveAction $moveAction)
    {
        $destinationProject = Project::findOrFail($request->selectedProject);
        $model = getModelByType($model, $modelId);
        $moveAction->execute($model, $destinationProject);

        return redirect($model->path());
    }
}
