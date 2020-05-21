<?php

namespace App\Http\Controllers\TodoLists;

use Illuminate\Http\Request;
use App\Models\TodoList;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;

class UpdateTodoListsSortController extends Controller
{

    public function __invoke(Account $account, Project $project, Request $request)
    {
        TodoList::setNewOrder($request->newSort);
        return redirect()->back();
    }
}
