<?php

namespace App\Models\Concerns;

use App\States\Status\Trashed;
use App\States\Status\StatusState;
use App\States\Status\Restored;
use App\States\Status\ArchivedToTrashed;
use App\States\Status\Archived;


trait HasStatus
{

    public function registerStatus()
    {
        $this->addState('status', StatusState::class)
            ->default(Restored::class)
            ->allowTransition(Archived::class, Trashed::class, ArchivedToTrashed::class)
            ->allowTransition([Archived::class, Trashed::class], Restored::class);
    }
}
