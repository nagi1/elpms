<?php

namespace App\States\Status;

use Spatie\ModelStates\Transition;
use Illuminate\Database\Eloquent\Model;

class ToTrashed extends Transition
{

    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function handle(): Model
    {
        $this->model->status = new Trashed($this->model);
        $this->model->unarchive();
        $this->model->delete();
        $this->model->save();

        return $this->model;
    }
}
