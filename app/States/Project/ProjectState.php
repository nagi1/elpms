<?php

namespace App\States\Project;

use Spatie\ModelStates\State;

abstract class ProjectState extends State
{
    public static $states = [];

    abstract public function name();
}
