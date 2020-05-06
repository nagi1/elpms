<?php

namespace App\States\Status;


use App\States\Status\StatusState;

class Trashed extends StatusState
{
    public static $name = 'trashed';

    public function name(): string
    {
        return static::$name;
    }
}
