<?php

namespace App\Models;

use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Contracts\CommentContract;
use App\Models\Contracts\BoostContract;
use App\Models\Concerns\MetaTrait;
use App\Models\Concerns\CommentTrait;
use App\Models\Concerns\BoostTrait;

class HillChartUpdate extends Model implements CommentContract, BoostContract
{
    use BoostTrait;
    use CommentTrait;
    use MetaTrait;
    use Subscribable;

    protected $guarded = [];

    public function Project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
