<?php

namespace App\Models;

use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Spatie\ModelStates\HasStates;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\States\MessageBoard\MessageBoardState;
use App\States\MessageBoard\Draft;
use App\Models\Project;

class MessageBoard extends Model
{
    use HasTrixRichText;
    use HasStates;

    protected $guarded = [];

    protected function registerStates(): void
    {
        $this->addState('state', MessageBoardState::class)
            ->default(Draft::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class);
    }
}
