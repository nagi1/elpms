<?php

namespace App\Http\Controllers\MessageBoards;

use Inertia\Inertia;
use App\Presenters\ProjectsPresenter;
use App\Presenters\MessageBoardsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;

class MessageBoardsArchiveIndexController extends Controller
{

    public function __invoke(Account $account, Project $project)
    {
        return Inertia::render('MessageBoards/Archive', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project)->preset('basic')->get(),
            'messageBoards' => MessageBoardsPresenter::collection($project->messageBoards()->with(['user.media', 'trixRichText', 'category'])->onlyArchived()->get())->preset('index')->get(),
        ]);
    }
}
