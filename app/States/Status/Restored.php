<?php

namespace App\States\Status;

use Spatie\ModelStates\Transition;
use Illuminate\Database\Eloquent\Model;

class ToPublished extends Transition
{

    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function handle(): Model
    {
        $this->model->state = new Restored($this->model);
        $this->unarchive();
        $this->restore();
        $this->model->save();

        return $this->model;
    }
}
