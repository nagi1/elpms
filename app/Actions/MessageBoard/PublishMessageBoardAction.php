<?php

namespace App\Actions\MessageBoard;

use App\States\MessageBoard\Published;
use App\Models\MessageBoard;

class PublishMessageBoardAction
{

    public function execute(MessageBoard $messageBoard)
    {
        return $messageBoard->state->transitionTo(Published::class);
    }
}
