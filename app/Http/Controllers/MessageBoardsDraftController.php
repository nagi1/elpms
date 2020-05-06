<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Presenters\ProjectsPresenter;
use App\Presenters\MessageBoardsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\MessageBoard;
use App\Models\Account;

class MessageBoardsDraftController extends Controller
{

    public function index(Account $account, Project $project)
    {
        return Inertia::render('MessageBoards/Draft', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project)->only('id', 'name')->get(),
            'messageBoards' => MessageBoardsPresenter::collection($project->messageBoards()->draft()->with(['category', 'trixRichText'])->get())->only('id', 'title', 'updated_at', 'excerpt', 'category')->get(),
        ]);
    }

    public function show(Account $account, Project $project, MessageBoard $messageBoard)
    {
        return Inertia::render('MessageBoards/ShowDraft', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project)->only('id', 'name')->get(),
            'messageBoard' => MessageBoardsPresenter::make($messageBoard->load(['user', 'trixRichText']))->only('id', 'title', 'user', 'trixRichText', 'updated_at')->get(),
        ]);
    }


    public function delete(Account $account, Project $project, MessageBoard $messageBoard)
    {
        $messageBoard->delete();
        return redirect()->back();
    }
}
