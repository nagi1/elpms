<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class TodoItemBuilder extends Builder
{
    public function completed()
    {
        $this->whereNotNull('completed_at');
        return $this;
    }

    public function orderedByUncompleted()
    {
        $this->orderByRaw('ISNULL(completed_at), completed_at ASC');
        return $this;
    }
}
