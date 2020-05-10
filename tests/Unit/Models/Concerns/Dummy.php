<?php

namespace Tests\Unit\Models\Concerns;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Sortable;
use App\Models\Concerns\HasMeta;

class Dummy extends Model
{
    use SoftDeletes, Sortable, HasMeta;

    protected $table = 'dummies';
    protected $guarded = [];
}
