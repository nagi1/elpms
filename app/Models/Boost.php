<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Boost extends Model
{
    protected $guarded = [];

    public function boostable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
