<?php

namespace App\Http\Controllers\Trash;

use Inertia\Inertia;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\States\Status\Trashed;
use App\Presenters\TodoListsPresenter;
use App\Presenters\TodoItemsPresenter;
use App\Presenters\ProjectsPresenter;
use App\Presenters\MessageBoardsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\TodoList;
use App\Models\TodoItem;
use App\Models\Project;
use App\Models\MessageBoard;
use App\Models\Account;
use App\Http\Controllers\Controller;

class TrashIndexController extends Controller
{
    private Collection $buckets;
    private Project $project;

    public function __construct()
    {
        $this->buckets = collect();
    }

    private function getTrashedMessageBoards()
    {
        $this->buckets->push(MessageBoardsPresenter::collection(MessageBoard::where('project_id', $this->project->id)->onlyTrashed()->with(['user.media', 'trixRichText', 'category'])->get())->preset('previewCard')->get());
    }

    private function getTrashedTodoLists()
    {
        $this->buckets->push(TodoListsPresenter::collection(TodoList::where('project_id', $this->project->id)->onlyTrashed()->with(['todoItems.trixRichText', 'user.media', 'todoItems.assignedTo.media', 'todoItems.todoList'])->get())->preset('previewCard')->get());
    }

    private function getTrashedTodoItems()
    {
        $this->buckets->push(TodoItemsPresenter::collection(TodoItem::whereHas('todoList', function ($query) {
            $query->where('project_id', $this->project->id);
        })->onlyTrashed()->with(['trixRichText', 'user.media', 'assignedTo.media', 'todoList'])->get())->preset('previewCard')->get());
    }

    public function __invoke(Account $account, Project $project)
    {
        $this->project = $project;

        $this->getTrashedMessageBoards();
        $this->getTrashedTodoLists();
        $this->getTrashedTodoItems();

        return Inertia::render('Trash/Index', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project)->preset('basic')->get(),
            'buckets' => $this->buckets->flatten(1)->sortByDesc('trashedAtDate')->values(),
        ]);
    }
}
