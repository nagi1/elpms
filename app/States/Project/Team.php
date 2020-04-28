<?php

namespace App\States\Project;

use App\States\Project\ProjectType;

class Team extends ProjectType
{
    public static $name = 'team';

    public function name()
    {
        return static::$name;
    }
}
