<?php

namespace App\Http\Controllers;

use Te7aHoudini\LaravelTrix\LaravelTrix;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Presenters\ProjectsPresenter;
use App\Presenters\CategoriesPresenter;
use App\Models\Project;
use App\Models\MessageBoard;
use App\Models\Account;
use App\Actions\MessageBoard\CreateMessageBoardAction;

class MessageBoardsController extends Controller
{
    public function index(Account $account, Project $project)
    {
    }

    public function create(Account $account, Project $project)
    {
        return Inertia::render('MessageBoards/Create', [
            'account' => $account->only(['id', 'name']),
            'project' => ProjectsPresenter::make($project)->only('id', 'name', 'categories')->get(),
            'trix' => $this->trixEditor(),
        ]);
    }

    public function store(Account $account, Project $project, Request $request)
    {
        $r =  (new CreateMessageBoardAction($project, [
            'title' => $request->title,
            'messageboard-trixFields' => $request->get('messageboard-trixFields'),
            'attachment-messageboard-trixFields' => $request->get('attachment-messageboard-trixFields'),
            'category_id' => $request->category,
            'state' => $request->state
        ]))->execute();

        return redirect()->route('messageBoards.index', ['account' => $account, 'project' => $project]);
    }

    private function trixEditor()
    {
        return (new LaravelTrix)->make(MessageBoard::class, 'content', ['id' => 'trix-input', 'containerElement' => 'div'])->__toString();
    }
}
