<?php

namespace App\Http\Controllers\Trash;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Trash\TrashAction;

class TrashController extends Controller
{
    public function store(Account $account, Project $project, Request $request, TrashAction $trashAction)
    {
        $model = getModelByType($request->model, $request->modelId);

        $trashAction->execute($model, !$model->trashed());
        return redirect()->back();
    }
}
