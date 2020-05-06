<?php

namespace App\States\Status;

use App\States\Status\StatusState;

class Archived extends StatusState
{
    public static $name = 'archived';

    public function name(): string
    {
        return static::$name;
    }
}
