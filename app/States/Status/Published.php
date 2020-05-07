<?php

namespace App\States\Status;

use App\States\Status\StatusState;

class Restored extends StatusState
{
    public static $name = 'restored';

    public function name(): string
    {
        return static::$name;
    }
}
