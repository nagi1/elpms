<?php

namespace App\Http\Controllers\TodoLists;

use Te7aHoudini\LaravelTrix\LaravelTrix;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Presenters\TodoListsPresenter;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\TodoList;
use App\Models\TodoItem;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\TodoList\UpdateTodoListAction;
use App\Actions\TodoList\CreateTodoListAction;

class TodoListsController extends Controller
{
    public function index(Account $account, Project $project)
    {
        // dd(ProjectsPresenter::make($project->load(['users.media']))->only('id', 'name', 'users', 'completedTodoItemsCount', 'todoItemsCount', 'hillChart')->get());
        return Inertia::render('TodoLists/Index', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load(['users.media']))->only('id', 'name', 'users', 'completedTodoItemsCount', 'todoItemsCount', 'hillChart')->get(),
            'trix' => trixEditorForModel(TodoList::class, 'details'),
            'todoItemTrix' => trixEditorForModel(TodoItem::class, 'notes'),
            'todoLists' => TodoListsPresenter::collection($project->todoLists()->withoutArchived()->latest()->with(['trixRichText',  'todoItems' => function ($query) {
                return $query->withoutArchived()->orderedByUncompleted()->ordered();
            },  'todoItems.trixRichText', 'todoItems.assignedTo.media', 'todoItems.notifiedWhenDone.media'])->ordered()->get())->get(),
            'archivedCount' => $project->todoLists()->onlyArchived()->count(),

        ]);
    }

    public function store(Account $account, Project $project, Request $request)
    {
        $request->validate(['name' => ['required']]);

        (new CreateTodoListAction($project, [
            'name' => $request->name,
            'color' => $request->color,
            'todolist-trixFields' => $request->get('todolist-trixFields'),
            'attachment-todolist-trixFields' => $request->get('attachment-todolist-trixFields'),
        ]))->execute();

        return redirect()->back();
    }

    public function update(Account $account, Project $project, TodoList $todoList, Request $request)
    {
        $request->validate(['name' => ['required']]);

        (new UpdateTodoListAction($todoList, [
            'name' => $request->name,
            'todolist-trixFields' => $request->get('todolist-trixFields'),
            'attachment-todolist-trixFields' => $request->get('attachment-todolist-trixFields'),
        ]))->execute();

        return redirect()->back();
    }
}
