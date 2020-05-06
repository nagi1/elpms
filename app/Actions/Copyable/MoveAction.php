<?php

namespace App\Actions\Copyable;

use App\Models\Project;
use App\Models\Concerns\Moveable;

class MoveAction
{

    public function __construct()
    {
    }

    public function execute(Moveable $model, Project $destinationProject)
    {
        $model->moveTo($destinationProject);
    }
}
