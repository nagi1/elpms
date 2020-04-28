<?php

namespace App\States\Project;

use Spatie\ModelStates\State;
use App\States\Project\Team;
use App\States\Project\Project;
use App\States\Project\Hq;

abstract class ProjectType extends State
{
    public static $states = [
        Hq::class,
        Team::class,
        Project::class,
    ];

    abstract public function name();
}
