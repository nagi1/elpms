<?php

namespace App\States\MessageBoard;


use Spatie\ModelStates\Transition;
use App\States\MessageBoard\Published;
use App\Models\MessageBoard;

class DraftToPublished extends Transition
{

    private MessageBoard $messageBoard;

    public function __construct(MessageBoard $messageBoard)
    {
        $this->messageBoard = $messageBoard;
    }

    public function handle(): MessageBoard
    {
        $this->messageBoard->state = new Published($this->messageBoard);
        $this->messageBoard->created_at = now();
        $this->messageBoard->save();

        return $this->messageBoard;
    }
}
