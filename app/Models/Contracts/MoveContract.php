<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

interface MoveContract
{
    public function moveTo(Project $project): Model;
}
