<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Contracts\BoostContract;
use App\Models\Concerns\BoostTrait;

class Event extends Model implements BoostContract
{
    use BoostTrait;

    protected $guarded = [];

    public function eventable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
