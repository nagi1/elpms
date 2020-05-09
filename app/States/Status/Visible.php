<?php

namespace App\States\Status;


use App\States\Status\Status;

class Visible extends Status
{
    public static $name = 'visible';

    public function name(): string
    {
        return static::$name;
    }
}
