<?php

namespace App\Models\Concerns;

use Illuminate\Support\Collection;
use App\User;
use App\Models\Pivots\Assignable;

trait AssignableTrait
{

    public function assignTo(Collection $users)
    {

        $this->assignedTo()->sync($users->pluck('id'));
    }

    public function whenDoneNotify(Collection $users)
    {
        $this->notifiedWhenDone()->sync($users->pluck('id'));
    }

    public function assignedTo()
    {
        return $this->morphToMany(User::class, 'assignable')
            ->using(Assignable::class)
            ->as('assignable')
            ->withPivotValue('type', 'assign')
            ->withPivot(['type'])
            ->withTimestamps();
    }

    public function notifiedWhenDone()
    {
        return $this->morphToMany(User::class, 'assignable')
            ->using(Assignable::class)
            ->as('assignable')
            ->withPivotValue('type', 'notify')
            ->withPivot(['type'])
            ->withTimestamps();
    }
}
