<?php

namespace App\States\Project;

use App\States\Project\ProjectType;

class Hq extends ProjectType
{
    public static $name = 'hq';

    public function name()
    {
        return static::$name;
    }
}
