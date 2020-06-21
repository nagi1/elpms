<?php

namespace App\Http\Controllers\Chat;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Cmgmyr\Messenger\Models\Thread;
use Cmgmyr\Messenger\Models\Message;
use Chat;
use App\Presenters\ProjectsPresenter;
use App\Presenters\MessagesPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index(Account $account, Project $project)
    {


        return Inertia::render('Chat/Index', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project)->preset('basic')->get(),
            'messages' => MessagesPresenter::collection($project->chat()
                ->messages()
                ->with(['user.media'])
                ->latest()
                ->simplePaginate(15))->get(),
        ]);
    }
}
