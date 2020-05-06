<?php

namespace App\Actions\MessageBoard;

use App\States\MessageBoard\Published;
use App\Models\MessageBoard;

class PublishMessageBoardAction
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(MessageBoard $messageBoard)
    {
        return $messageBoard->state->transitionTo(Published::class);
    }
}
