<?php

namespace App\Http\Controllers\MessageBoards;

use Te7aHoudini\LaravelTrix\LaravelTrix;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Auth;
use App\Presenters\ProjectsPresenter;
use App\Presenters\MessageBoardsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\MessageBoard;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\MessageBoard\GetMessageBoardByCategoryAction;
use App\Actions\MessageBoard\CreateMessageBoardAction;

class MessageBoardsController extends Controller
{
    public function index(Account $account, Project $project)
    {

        $category = request()->query('categoryId');

        return Inertia::render('MessageBoards/Index', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load(['categories']))->only('id', 'name', 'categories', 'MessageBoardMeta')->get(),
            'messageBoards' => MessageBoardsPresenter::collection((new GetMessageBoardByCategoryAction($project, $category))->execute())->preset('index')->get(),
            'draftsCount' => $project->messageBoards()->draft()->byUser(Auth::id())->count(),
            'archivedCount' => $project->messageBoards()->onlyArchived()->count(),
            'categoryFilter' => (string) $category,
        ]);
    }

    public function create(Account $account, Project $project)
    {
        return Inertia::render('MessageBoards/Create', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load(['categories']))->only('id', 'name', 'categories')->get(),
            'trix' => $this->trixEditor(),
        ]);
    }

    public function store(Account $account, Project $project, Request $request)
    {
        $messageBoard = (new CreateMessageBoardAction($project, [
            'title' => $request->title,
            'messageboard-trixFields' => $request->get('messageboard-trixFields'),
            'attachment-messageboard-trixFields' => $request->get('attachment-messageboard-trixFields'),
            'category_id' => $request->category,
            'state' => $request->state
        ]))->execute();

        return redirect($messageBoard->path());
    }

    private function trixEditor()
    {
        return (new LaravelTrix)->make(MessageBoard::class, 'content', ['id' => 'trix-input', 'containerElement' => 'div'])->__toString();
    }
}
