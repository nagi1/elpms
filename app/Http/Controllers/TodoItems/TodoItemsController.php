<?php

namespace App\Http\Controllers\TodoItems;

use Illuminate\Http\Request;
use App\Models\TodoList;
use App\Models\TodoItem;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\TodoItem\UpdateTodoItemAction;
use App\Actions\TodoItem\CreateTodoItemAction;

class TodoItemsController extends Controller
{
    public function store(Account $account, Project $project, TodoList $todoList, Request $request)
    {

        $request->validate(['description' => ['required']]);
        (new CreateTodoItemAction($todoList, [
            'description' => $request->description,
            'assignedTo' => $request->assignedTo,
            'whenDoneNotify' => $request->notify,
            'notifyAssignedUsers' => $request->notifyAssignedUsers,
            'dueOn' => $request->dueOn,
            'todoitem-trixFields' => $request->get('todoitem-trixFields'),
            'attachment-todoitem-trixFields' => $request->get('attachment-todoitem-trixFields'),
        ]))->execute();

        return redirect()->back();
    }

    public function update(Account $account, Project $project, TodoList $todoList, TodoItem $todoItem, Request $request)
    {

        $request->validate(['description' => ['required']]);
        (new UpdateTodoItemAction($todoItem, [
            'description' => $request->description,
            'assignedTo' => $request->assignedTo,
            'whenDoneNotify' => $request->notify,
            'notifyAssignedUsers' => $request->notifyAssignedUsers,
            'dueOn' => $request->dueOn,
            'todoitem-trixFields' => $request->get('todoitem-trixFields'),
            'attachment-todoitem-trixFields' => $request->get('attachment-todoitem-trixFields'),
        ]))->execute();

        return redirect()->back();
    }
}
