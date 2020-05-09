<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Project\SetMessagesSortByAction;

class MessagesSortByController extends Controller
{
    public function __invoke(Account $account, Project $project, Request $request, SetMessagesSortByAction $setMessagesSortByAction)
    {
        $setMessagesSortByAction->execute($project, current($request->validate([
            'sortBy' => ['in:created_at,last_comment,updated_at,title']
        ])));

        return redirect()->back()->with('success', "Sort order changed!");
    }
}
