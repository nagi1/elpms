<?php

namespace App\Actions\Trash;

use Illuminate\Database\Eloquent\Model;
use App\States\Status\Visible;
use App\States\Status\Trashed;
use App\States\Status\ToTrashed;
use App\States\Status\ArchivedToTrashed;

class TrashAction
{

    public function execute(Model $model, bool $trash = true): void
    {
        if (!$trash) {
            $model->status->transitionTo(Visible::class);
            return;
        }

        // if ($model->archived()) {
        //     $model->status->transitionTo(ArchivedToTrashed::class);
        //     return;
        // }

        $model->status->transitionTo(Trashed::class);
        // Activity::inLog("project-{$model->project->id}")->where('properties->data->id', $model->id)->first()->delete();
    }
}
