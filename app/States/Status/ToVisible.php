<?php

namespace App\States\Status;

use Spatie\ModelStates\Transition;
use Illuminate\Database\Eloquent\Model;
use App\User;

class ToVisible extends Transition
{

    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function handle(): Model
    {
        $this->model->status = new Visible($this->model);
        $this->model->restore();
        $this->model->unarchive();
        $this->model->save();

        return $this->model;
    }
}
