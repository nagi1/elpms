<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

interface Moveable
{
    public function moveTo(Project $project): Model;
}
