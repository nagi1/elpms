<?php

namespace App\States\Status;

use App\States\Status\StatusState;

class Published extends StatusState
{
    public static $name = 'published';

    public function name(): string
    {
        return static::$name;
    }
}
