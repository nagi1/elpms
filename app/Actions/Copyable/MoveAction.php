<?php

namespace App\Actions\Copyable;

use App\Models\Project;
use App\Models\Contracts\MoveContract;

class MoveAction
{
    public function execute(MoveContract $model, Project $destinationProject)
    {
        $model->moveTo($destinationProject);
    }
}
