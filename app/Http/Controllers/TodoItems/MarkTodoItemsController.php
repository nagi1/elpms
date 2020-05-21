<?php

namespace App\Http\Controllers\TodoItems;

use Illuminate\Http\Request;
use App\Models\TodoList;
use App\Models\TodoItem;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\TodoItem\MarkTodoItemAction;

class MarkTodoItemsController extends Controller
{

    public function __invoke(Account $account, Project $project, TodoList $todoList, TodoItem $todoItem, Request $request, MarkTodoItemAction $markTodoItemAction)
    {
        $markTodoItemAction->execute($todoItem, $request->completed);
        return  redirect()->back();
    }
}
