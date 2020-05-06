<?php

namespace App\Actions\Archiveable;

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

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(Archiveable $model, bool $archive = true): void
    {
        if (!$archive) {
            $model->unarchive();
            return;
        }

        $model->archive();
    }
}
