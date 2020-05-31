<?php

namespace App\Models;

use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Spatie\ModelStates\HasStates;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Project;
use App\Models\Contracts\MoveContract;
use App\Models\Contracts\CommentContract;
use App\Models\Contracts\ChangeEventContract;
use App\Models\Contracts\BucketContract;
use App\Models\Contracts\BoostContract;
use App\Models\Concerns\StatusTrait;
use App\Models\Concerns\MoveTrait;
use App\Models\Concerns\MetaTrait;
use App\Models\Concerns\CommentTrait;
use App\Models\Concerns\ChangeEventTrait;
use App\Models\Concerns\BoostTrait;
use App\Models\Concerns\AssignableTrait;
use App\Models\Concerns\ArchiveTrait;
use App\Builders\EventBuilder;

class Event extends Model implements BucketContract, MoveContract, BoostContract, ChangeEventContract, CommentContract
{
    use HasTrixRichText;
    use CommentTrait;
    use MoveTrait;
    use ArchiveTrait;
    use MetaTrait;
    use SoftDeletes;
    use StatusTrait;
    use HasStates;
    use Subscribable;
    use AssignableTrait;
    use BoostTrait;
    use ChangeEventTrait;

    protected $guarded = [];
    protected $touches = ['trixRichText'];

    protected $dates = [
        'starts_at', 'ends_at'
    ];

    protected function registerStates(): void
    {
        $this->registerStatus();
    }

    public static function query(): EventBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query)
    {
        return new EventBuilder($query);
    }

    public function getContentAttribute()
    {
        return optional($this->trixRichText->first())->content;
    }

    public function displayName(): string
    {
        return 'Schedule';
    }

    public function displayField(): string
    {
        return $this->name;
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function occurrences(): HasMany
    {
        return $this->hasMany(Event::class, 'event_id');
    }

    public function parentEvent(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function previewCard(): array
    {
        // $modelPresenter = getModelPresenter($this);
        // return $modelPresenter::make($this->load(['todoItems.trixRichText', 'todoItems.assignedTo.media', 'todoItems.todoList']))->preset('previewCard')->get();
        return [];
    }

    public function path(): string
    {
        return '';
        // return route('todoLists.show', [
        //     'account' => session('account_id', fn () => $this->project->account_id),
        //     'project' => $this->project_id,
        //     'todoList' => $this->id
        // ]);
    }


    public function indexPath(): string
    {
        return '';
        // return route('todoLists.index', [
        //     'account' => session('account_id', fn () => $this->project->account_id),
        //     'project' => $this->project_id,
        // ]);
    }
}
