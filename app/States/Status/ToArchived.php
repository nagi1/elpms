<?php

namespace App\States\Status;

use Spatie\ModelStates\Transition;
use Illuminate\Database\Eloquent\Model;
use App\User;

class ToArchived extends Transition
{

    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function handle(): Model
    {
        $this->model->status = new Archived($this->model);
        $this->model->restore();
        $this->model->archive();
        $this->model->save();

        return $this->model;
    }
}
