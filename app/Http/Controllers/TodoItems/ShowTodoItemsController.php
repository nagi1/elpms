<?php

namespace App\Http\Controllers\TodoItems;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Presenters\TodoListsPresenter;
use App\Presenters\TodoItemsPresenter;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\TodoList;
use App\Models\TodoItem;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Account;
use App\Http\Controllers\Controller;

class ShowTodoItemsController extends Controller
{
    public function __invoke(Account $account, Project $project, TodoList $todoList, TodoItem $todoItem)
    {

        return Inertia::render('TodoItems/Show', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load(['users.media']))->only('id', 'name', 'users')->get(),
            'todoItem' => TodoItemsPresenter::make($todoItem->load(['trixRichText', 'user.media', 'assignedTo.media', 'notifiedWhenDone.media', 'comments.user.media', 'comments.boosts.user.media', 'comments.trixRichText', 'boosts.user.media', 'subscribers.media', 'changeEvents.user.media', 'changeEvents.boosts']))->preset('show')->get(),
            'todoList' => TodoListsPresenter::make($todoList)->only('id', 'name')->get(),
            'commentsTrix' => trixEditorForModel(Comment::class),
            'todoItemTrix' => trixEditorForModel(TodoItem::class),
        ]);
    }
}
