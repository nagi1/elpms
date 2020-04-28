<?php

namespace App\States\MessageBoard;

use Spatie\ModelStates\State;
use App\States\MessageBoard\Published;
use App\States\MessageBoard\Draft;


abstract class MessageBoardState extends State
{
    public static $states = [
        Draft::class,
        Published::class,
    ];

    abstract public function name(): string;
}
