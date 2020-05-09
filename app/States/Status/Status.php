<?php

namespace App\States\Status;

use Spatie\ModelStates\State;

abstract class Status extends State
{
    public static $states = [
        Visible::class,
        Archived::class,
        Trashed::class,
    ];

    abstract public function name(): string;
}
