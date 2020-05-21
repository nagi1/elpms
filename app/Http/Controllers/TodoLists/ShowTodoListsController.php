<?php

namespace App\Http\Controllers\TodoLists;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Presenters\TodoListsPresenter;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\TodoList;
use App\Models\TodoItem;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Account;
use App\Http\Controllers\Controller;

class ShowTodoListsController extends Controller
{
    public function __invoke(Account $account, Project $project, TodoList $todoList)
    {
        return Inertia::render('TodoLists/Show', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load(['users.media']))->only('id', 'name', 'users')->get(),
            'todoList' => TodoListsPresenter::make($todoList->load(['trixRichText', 'user.media', 'todoItems.user.media', 'todoItems' => function ($query) {
                return $query->withoutArchived()->orderedByUncompleted()->ordered();
            }, 'todoItems.trixRichText', 'todoItems.assignedTo.media', 'comments.user.media', 'comments.boosts.user.media', 'comments.trixRichText', 'boosts.user.media', 'subscribers.media', 'todoItems.notifiedWhenDone.media']))->get(),
            'commentsTrix' => trixEditorForModel(Comment::class),
            'todoItemTrix' => trixEditorForModel(TodoItem::class),
            'archivedCount' => $todoList->todoItems()->onlyArchived()->count(),
        ]);
    }
}
