<?php

namespace App\Models\Concerns;

use Spatie\ModelStates\HasStates;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\States\Status\Trashed;
use App\States\Status\ToPublished;
use App\States\Status\StatusState;
use App\States\Status\Published;
use App\States\Status\ArchivedToTrashed;
use App\States\Status\Archived;

trait HasStatus
{
    use HasStates;
    use CanArchived;
    use SoftDeletes;

    public function bootStatusable()
    {
        dd($this->addState());
        $this->addState('status', StatusState::class)
            ->default(Published::class)
            ->allowTransition(Archived::class, Trashed::class, ArchivedToTrashed::class)
            ->allowTransition([Archived::class, Trashed::class], ToPublished::class);
    }
}
