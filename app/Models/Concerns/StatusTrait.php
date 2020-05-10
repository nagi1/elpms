<?php

namespace App\Models\Concerns;

use App\States\Status\Visible;
use App\States\Status\Trashed;
use App\States\Status\ToVisible;
use App\States\Status\ToTrashed;
use App\States\Status\ToArchived;
use App\States\Status\Status;
use App\States\Status\ArchivedToTrashed;
use App\States\Status\Archived;

trait StatusTrait
{

    public function registerStatus()
    {
        $this->addState('status', Status::class)
            ->default(Visible::class)
            ->allowTransition(Visible::class, Archived::class, ToArchived::class)
            ->allowTransition(Visible::class, Trashed::class, ToTrashed::class)
            ->allowTransition(Archived::class, Trashed::class, ArchivedToTrashed::class)
            ->allowTransition(Archived::class, Visible::class, ToVisible::class);
    }
}
