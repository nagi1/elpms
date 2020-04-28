<?php

namespace App\States\MessageBoard;

use App\States\MessageBoard\MessageBoardState;

class Draft extends MessageBoardState
{
    public static $name = 'draft';

    public function name(): string
    {
        return static::$name;
    }
}
