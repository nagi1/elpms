<?php

namespace App\Http\Controllers\TodoItems;

use Illuminate\Http\Request;
use App\Models\TodoList;
use App\Models\TodoItem;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;

class UpdateTodoItemsSortController extends Controller
{
    public function __invoke(Account $account, Project $project, TodoList $todoList, Request $request)
    {

        TodoItem::setNewOrder($request->newSort);
        return redirect()->back();
    }
}
