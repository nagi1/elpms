<?php

namespace App\Http\Controllers;

use ReflectionClass;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Concerns\Boostable;
use App\Models\Boost;
use App\Models\Account;
use App\Actions\Boost\DeleteBoostAction;
use App\Actions\Boost\AddBoostAction;

class BoostsController extends Controller
{
    public function store(Account $account, Project $project, Request $request, AddBoostAction $addBoostAction)
    {
        $addBoostAction->execute($request->validate([
            'content' => ['required', 'max:16'],
        ]), getModelByType($request->model, $request->modelId));

        return redirect()->back();
    }


    public function delete(Account $account, Project $project, Boost $boost, DeleteBoostAction $deleteBoostAction)
    {
        $deleteBoostAction->execute($boost);
        return redirect()->back();
    }
}
