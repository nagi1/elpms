<?php

namespace App\Http\Controllers\MessageBoards;

use Te7aHoudini\LaravelTrix\LaravelTrix;
use Inertia\Inertia;
use App\Presenters\ProjectsPresenter;
use App\Presenters\MessageBoardsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\MessageBoard;
use App\Models\Comment;
use App\Models\Account;
use App\Http\Controllers\Controller;

class ShowMessageBoardMessageController extends Controller
{
    public function __invoke(Account $account, Project $project, MessageBoard $messageBoard)
    {
        return Inertia::render('MessageBoards/Show', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project)->only('id', 'name')->get(),
            'messageBoard' => MessageBoardsPresenter::make($messageBoard->load([
                'user.media', 'category', 'trixRichText', 'comments.user.media', 'comments.boosts.user.media', 'comments.trixRichText', 'boosts.user.media', 'subscribers.media'
            ]))->get(),
            'trix' => $this->trixEditor(),
        ]);
    }

    private function trixEditor()
    {
        return (new LaravelTrix)->make(Comment::class, 'content', ['id' => 'trix-input', 'containerElement' => 'div'])->__toString();
    }
}
