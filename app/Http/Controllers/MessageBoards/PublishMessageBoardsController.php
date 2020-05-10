<?php

namespace App\Http\Controllers\MessageBoards;

use App\Models\Project;
use App\Models\MessageBoard;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\MessageBoard\PublishMessageBoardAction;

class PublishMessageBoardsController extends Controller
{
    public function __invoke(Account $account, Project $project, MessageBoard $messageBoard, PublishMessageBoardAction $publishMessageBoardAction)
    {
        $publishMessageBoardAction->execute($messageBoard);
        return redirect($messageBoard->path());
    }
}
