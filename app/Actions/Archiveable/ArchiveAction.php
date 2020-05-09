<?php

namespace App\Actions\Archiveable;

use Illuminate\Database\Eloquent\Model;
use App\States\Status\Visible;
use App\States\Status\Archived;
use App\Models\Concerns\Archiveable;

class ArchiveAction
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    public function execute(Model $model, bool $archive = true): void
    {


        if (!$archive) {
            $model->status->transitionTo(Visible::class);
            return;
        }


        $model->status->transitionTo(Archived::class);
    }
}
