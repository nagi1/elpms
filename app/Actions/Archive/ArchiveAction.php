<?php

namespace App\Actions\Archive;

use Illuminate\Database\Eloquent\Model;
use App\States\Status\Visible;
use App\States\Status\Archived;

class ArchiveAction
{

    public function execute(Model $model, bool $archive = true): void
    {
        if (!$archive) {
            $model->status->transitionTo(Visible::class);
            return;
        }

        // Activity::inLog("project-{$model->project->id}")->where('properties->data->id', $model->id)->first()->delete();
        $model->status->transitionTo(Archived::class);
    }
}
