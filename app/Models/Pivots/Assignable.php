<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use App\User;

class Assignable extends MorphPivot
{
    public $incrementing = true;

    public $table = 'assignables';

    public function assignable()
    {
        return $this->morphTo('assignable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
