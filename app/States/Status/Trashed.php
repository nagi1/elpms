<?php

namespace App\States\Status;


use App\States\Status\Status;

class Trashed extends Status
{
    public static $name = 'trashed';

    public function name(): string
    {
        return static::$name;
    }
}
