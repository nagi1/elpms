<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\MessageBoard;
use App\Models\Account;
use App\Actions\MessageBoard\PublishMessageBoardAction;

class PublishMessageBoardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Account $account, Project $project, MessageBoard $messageBoard, PublishMessageBoardAction $publishMessageBoardAction)
    {
        $publishMessageBoardAction->execute($messageBoard);
        return redirect()->route('messageBoard.show', [
            'account' => $account->id,
            'project' => $project->id,
            'messageBoard' => $messageBoard->id
        ]);
    }
}
