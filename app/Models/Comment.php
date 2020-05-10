<?php

namespace App\Models;

use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Contracts\CommentContract;
use App\Models\Contracts\BoostContract;
use App\Models\Concerns\MetaTrait;
use App\Models\Concerns\CommentTrait;
use App\Models\Concerns\BoostTrait;

class Comment extends Model implements BoostContract, CommentContract
{
    use HasTrixRichText;
    use CommentTrait;
    use MetaTrait;
    use BoostTrait;

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
