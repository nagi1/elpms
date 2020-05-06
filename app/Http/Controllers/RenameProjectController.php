<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Account;

class RenameProjectController extends Controller
{
    public function __invoke(Request $request, Account $account, Project $project)
    {
        $project->update($request->validate([
            'name' => ['required']
        ]));

        return Redirect::back();
    }
}
