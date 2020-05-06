<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Account;
use App\Actions\Project\PinProjectAction;

class PinProjectController extends Controller
{
    public function __invoke(Request $request, Account $account, Project $project)
    {

        (new PinProjectAction($project, $request->pinned))->execute();

        return Redirect::back();
    }
}
