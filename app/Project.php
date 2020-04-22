<?php

namespace App;

use App\User;
use App\ProjectType;

class Project extends ProjectType
{
    public function clients()
    {
        return $this->belongsToMany(User::class, 'client_project', 'project_id', 'user_id')
            ->withTimestamps();
    }
}
