<?php

namespace App\Http\Controllers;

use ReflectionClass;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Concerns\Moveable;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Copyable\MoveAction;

class MoveController extends Controller
{
    public function show(Account $account, Project $project, $model, $id)
    {
        getModelByType($model, $id);

        return Inertia::render('Move/Show', [
            'account' => AccountsPresenter::make($account)->preset('basic'),
            'project' => ProjectsPresenter::make($project)->only('id', 'name'),
            'projects' => ProjectsPresenter::collection(Auth::user()->projects)->only('id', 'name')->get(),
            'model' => $model,
            'modelId' => $id,

        ]);
    }

    public function store(Account $account, Project $project, Request $request, $model, $id)
    {
        $destinationProject = Project::findOrFail($request->selectedProject);
        $model = getModelByType($model, $id);
        (new MoveAction)->execute($model, $destinationProject);

        return redirect($model->path());
    }
}
