<?php

namespace App\States\MessageBoard;


use App\States\MessageBoard\MessageBoardState;

class Published extends MessageBoardState
{
    public static $name = 'published';

    public function name(): string
    {
        return static::$name;
    }
}
