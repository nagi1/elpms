<?php

namespace App\States\Status;

use App\States\Status\Status;

class Archived extends Status
{
    public static $name = 'archived';

    public function name(): string
    {
        return static::$name;
    }
}
