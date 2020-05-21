<?php

namespace App\Http\Controllers\TodoItems;

use Inertia\Inertia;
use App\Presenters\TodoListsPresenter;
use App\Presenters\TodoItemsPresenter;
use App\Presenters\ProjectsPresenter;
use App\Presenters\MessageBoardsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\TodoList;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;

class TodoItemsArchiveIndexController extends Controller
{

    public function __invoke(Account $account, Project $project, TodoList $todoList)
    {

        return Inertia::render('TodoItems/Archive', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project)->preset('basic')->get(),
            'todoList' => TodoListsPresenter::make($todoList)->only('id', 'name'),
            'todoItems' => TodoItemsPresenter::collection($todoList->todoItems()->with(['trixRichText', 'assignedTo.media'])->onlyArchived()->get())->preset('archive')->get(),
        ]);
    }
}
