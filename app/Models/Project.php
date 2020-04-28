<?php

namespace App\Models;

use Spatie\ModelStates\HasStates;
use PDO;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\States\Project\ProjectType;
use App\States\Project\ProjectState;
use App\Scopes\Project\OrderScope;
use App\Models\Pivots\ProjectUsers;
use App\Models\MessageBoard;
use App\Models\Account;
use App\Builders\ProjectBuilder;

/**
 * @property \App\States\Project\ProjectType $type
 */
class Project extends Model
{
    use HasStates;

    protected $guarded = [];
    protected $casts = [
        'pinned' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new OrderScope);
    }

    public static function query(): ProjectBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query)
    {
        return new ProjectBuilder($query);
    }

    protected function registerStates(): void
    {
        $this->addState('type', ProjectType::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(ProjectUsers::class)
            ->as('projectUsers')
            ->withTimestamps();
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function messageBoards()
    {
        return $this->hasMany(MessageBoard::class);
    }
}
