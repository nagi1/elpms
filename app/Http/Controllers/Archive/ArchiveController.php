<?php

namespace App\Http\Controllers\Archive;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Archive\ArchiveAction;


class ArchiveController extends Controller
{
    public function store(Account $account, Project $project, Request $request, ArchiveAction $archiveAction)
    {
        $model = getModelByType($request->model, $request->modelId);

        $archiveAction->execute($model, !$model->archived());
        return redirect()->back();
    }
}
