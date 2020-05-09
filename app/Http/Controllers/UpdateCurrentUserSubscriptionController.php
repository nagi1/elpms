<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Account;

class UpdateCurrentUserSubscriptionController extends Controller
{

    public function __invoke(Account $account, Project $project, Request $request)
    {
        $model = getModelByType($request->model, $request->modelId);
        Auth::user()->toggleSubscribe($model);
        return redirect()->back();
    }
}
