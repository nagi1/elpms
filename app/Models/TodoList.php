<?php

namespace App\Models;

use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Spatie\ModelStates\HasStates;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\EloquentSortable\Sortable;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Project;
use App\Models\Contracts\MoveContract;
use App\Models\Contracts\CommentContract;
use App\Models\Contracts\BucketContract;
use App\Models\Contracts\BoostContract;
use App\Models\Contracts\ArchiveContract;
use App\Models\Concerns\StatusTrait;
use App\Models\Concerns\MoveTrait;
use App\Models\Concerns\MetaTrait;
use App\Models\Concerns\HillChartTrait;
use App\Models\Concerns\CommentTrait;
use App\Models\Concerns\BoostTrait;
use App\Models\Concerns\ArchiveTrait;
use App\Events\TodoList\TodoListUnarchivedEvent;
use App\Events\TodoList\TodoListArchivedEvent;
use App\Builders\TodoListBuilder;

class TodoList extends Model implements BucketContract, CommentContract, MoveContract, ArchiveContract, Sortable, BoostContract
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
    use SortableTrait;
    use BoostTrait;
    use HillChartTrait;


    protected $dispatchesEvents = [
        'archived' =>  TodoListArchivedEvent::class,
        'unarchived' =>  TodoListUnarchivedEvent::class,
    ];

    protected $guarded = [];

    protected $touches = ['trixRichText'];


    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function getContentAttribute()
    {
        return optional($this->trixRichText->first())->content;
    }

    protected function registerStates(): void
    {
        $this->registerStatus();
    }

    public static function query(): TodoListBuilder
    {
        return parent::query();
    }

    public function buildSortQuery()
    {
        return static::query()->where('project_id', $this->project_id);
    }

    public function newEloquentBuilder($query)
    {
        return new TodoListBuilder($query);
    }

    public function displayName(): string
    {
        return 'To-dos';
    }

    public function displayField(): string
    {
        return $this->name;
    }

    public function todoItems(): HasMany
    {
        return $this->hasMany(TodoItem::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function previewCard(): array
    {
        $modelPresenter = getModelPresenter($this);
        return $modelPresenter::make($this->load(['todoItems.trixRichText', 'todoItems.assignedTo.media', 'todoItems.todoList']))->preset('previewCard')->get();
    }

    public function path(): string
    {
        return route('todoLists.show', [
            'account' => session('account_id', fn () => $this->project->account_id),
            'project' => $this->project_id,
            'todoList' => $this->id
        ]);
    }

    public function indexPath(): string
    {
        return route('todoLists.index', [
            'account' => session('account_id', fn () => $this->project->account_id),
            'project' => $this->project_id,
        ]);
    }
}
