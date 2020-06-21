<?php

namespace App\Models;

use Spatie\ModelStates\HasStates;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Cmgmyr\Messenger\Models\Thread;
use App\User;
use App\States\Project\ProjectType;
use App\Scopes\Project\OrderScope;
use App\Models\TodoList;
use App\Models\Pivots\ProjectUser;
use App\Models\MessageBoard;
use App\Models\HillChartUpdate;
use App\Models\Concerns\MetaTrait;
use App\Models\Account;
use App\Builders\ProjectBuilder;

/**
 * @property \App\States\Project\ProjectType $type
 */
class Project extends Model
{
    use HasStates;
    use MetaTrait;
    use Subscribable;


    protected $guarded = [];

    protected $casts = [
        'pinned' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::retrieved(function (Project $project) {
            session(['project_id' => $project->id]);
        });
    }

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
            ->using(ProjectUser::class)
            ->as('projectUsers')
            ->withTimestamps();
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function messageBoards(): HasMany
    {
        return $this->hasMany(MessageBoard::class);
    }

    public function todoLists(): HasMany
    {
        return $this->hasMany(TodoList::class);
    }

    public function hillChartUpdates(): HasMany
    {
        return $this->hasMany(HillChartUpdate::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function chat(): Thread
    {
        return Thread::where('subject', "project-{$this->id}")
            ->first();
    }

    public function toggleHillChart(?bool $state = null): void
    {
        if (is_null($state)) {
            $currentState = $this->meta->get('hillChart', false);

            $this->meta->set([
                'hillChart' => $currentState ? false : true
            ]);

            $this->save();

            return;
        }

        $this->meta->set('hillChart', $state);
        $this->save();
    }
}
