<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Presenters\ProjectsPresenter;
use App\Presenters\MessageBoardsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Account;

class MessageBoardArchiveController extends Controller
{

    public function __invoke(Account $account, Project $project)
    {

        return Inertia::render('MessageBoards/Archive', [
            'account' => AccountsPresenter::make($account)->preset('basic'),
            'project' => ProjectsPresenter::make($project)->preset('basic'),
            'messageBoards' => MessageBoardsPresenter::collection($project->messageBoards()->with(['user.media', 'trixRichText', 'category'])->onlyArchived()->get())->preset('index'),
        ]);
    }
}
