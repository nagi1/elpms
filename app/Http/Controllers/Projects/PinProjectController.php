<?php

namespace App\Http\Controllers\Projects;

use Redirect;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Project\PinProjectAction;

class PinProjectController extends Controller
{
    public function __invoke(Request $request, Account $account, Project $project, PinProjectAction $pinProjectAction)
    {
        $pinProjectAction->execute($project, $request->pinned);
        return Redirect::back();
    }
}
