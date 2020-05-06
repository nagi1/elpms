<?php

namespace App\States\Status;

use Spatie\ModelStates\State;

abstract class StatusState extends State
{
    public static $states = [
        Archived::class,
        Trashed::class,
        Published::class,
    ];

    abstract public function name(): string;
}
