<?php

namespace App\States\Project;

use App\States\Project\ProjectType;

class Project extends ProjectType
{
    public static $name = 'project';

    public function name()
    {
        return static::$name;
    }
}
