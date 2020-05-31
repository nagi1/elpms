<?php

namespace App\Models;

use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Spatie\ModelStates\HasStates;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\EloquentSortable\Sortable;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Contracts\MoveContract;
use App\Models\Contracts\CommentContract;
use App\Models\Contracts\ChangeEventContract;
use App\Models\Contracts\BucketContract;
use App\Models\Contracts\BoostContract;
use App\Models\Contracts\ArchiveContract;
use App\Models\Concerns\StatusTrait;
use App\Models\Concerns\MoveTrait;
use App\Models\Concerns\MetaTrait;
use App\Models\Concerns\CommentTrait;
use App\Models\Concerns\ChangeEventTrait;
use App\Models\Concerns\BoostTrait;
use App\Models\Concerns\AssignableTrait;
use App\Models\Concerns\ArchiveTrait;
use App\Events\TodoItem\TodoItemUnarchivedEvent;
use App\Events\TodoItem\TodoItemArchivedEvent;
use App\Builders\TodoItemBuilder;

class TodoItem extends Model implements CommentContract, MoveContract, Sortable, BoostContract, ChangeEventContract, ArchiveContract
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
    use AssignableTrait;
    use BoostTrait;
    use ChangeEventTrait;

    protected $dispatchesEvents = [
        'archived' =>  TodoItemArchivedEvent::class,
        'unarchived' =>  TodoItemUnarchivedEvent::class,
    ];

    protected $guarded = [];

    protected $touches = ['trixRichText', 'todoList'];

    protected $dates = [
        'completed_at', 'starts_at', 'ends_at'
    ];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];



    protected static function booted()
    {
        // static::addGlobalScope('ordered', function ($query) {
        //     return $query->orderedByUncompleted();
        // });
    }

    protected function registerStates(): void
    {
        $this->registerStatus();
    }

    public static function query(): TodoItemBuilder
    {
        return parent::query();
    }

    public function buildSortQuery()
    {
        return static::query()->where('todo_list_id', $this->todo_list_id);
    }

    public function newEloquentBuilder($query)
    {
        return new TodoItemBuilder($query);
    }

    public function displayField(): string
    {
        return $this->description;
    }

    public function displayName(): string
    {
        return 'To-do';
    }

    public function getContentAttribute()
    {
        return optional($this->trixRichText->first())->content;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function todoList(): BelongsTo
    {
        return $this->belongsTo(TodoList::class);
    }

    public function previewCard(): array
    {
        $modelPresenter = getModelPresenter($this);
        return $modelPresenter::make($this->load(['trixRichText', 'assignedTo.media',  'todoList']))->preset('previewCard')->get();
    }

    public function path(): string
    {
        return route('todoItems.show', [

            'account' => session('account_id', fn () => $this->todoList->project->account_id),
            'project' => session('project_id', fn () => $this->todoList->project_id),
            'todoList' => $this->todo_list_id,
            'todoItem' => $this->id
        ]);
    }

    public function indexPath(): string
    {
        return route('todoLists.index', [
            'account' => session('account_id', fn () => $this->project->account_id),
            'project' => session('project_id', fn () =>  $this->todoList->project_id),
        ]);
    }
}
