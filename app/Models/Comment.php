<?php

namespace App\Models;

use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Concerns\HasMeta;
use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasBoosts;
use App\Models\Concerns\Boostable;

class Comment extends Model implements Boostable
{
    use HasTrixRichText;
    use HasComments;
    use HasMeta;
    use HasBoosts;

    protected $guarded = [];


    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
