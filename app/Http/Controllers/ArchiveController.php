<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Account;
use App\Actions\Archiveable\ArchiveAction;

class ArchiveController extends Controller
{
    public function store(Account $account, Project $project, Request $request, ArchiveAction $archiveAction)
    {
        $model = getModelByType($request->model, $request->modelId);

        if ($model->archived()) {
            $archiveAction->execute($model, false);
        } else {
            $archiveAction->execute($model);
        }


        return redirect()->back();
    }
}
