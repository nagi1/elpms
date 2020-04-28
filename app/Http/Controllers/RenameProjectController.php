<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Account;
use App\Actions\Project\RenameProjectAction;

class RenameProjectController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Account $account, Project $project, RenameProjectAction $renameProjectAction)
    {
        $renameProjectAction->execute($request->validate([
            'name' => ['required']
        ])['name'], $project);

        return Redirect::back();
    }
}
