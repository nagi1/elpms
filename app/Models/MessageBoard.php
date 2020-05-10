<?php

namespace App\Models;

use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Spatie\ModelStates\HasStates;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\States\MessageBoard\Published;
use App\States\MessageBoard\MessageBoardState;
use App\States\MessageBoard\DraftToPublished;
use App\States\MessageBoard\Draft;
use App\Models\Project;
use App\Models\Contracts\MoveContract;
use App\Models\Contracts\CommentContract;
use App\Models\Contracts\BucketContract;
use App\Models\Contracts\BoostContract;
use App\Models\Contracts\ArchiveContract;
use App\Models\Concerns\StatusTrait;
use App\Models\Concerns\MoveTrait;
use App\Models\Concerns\MetaTrait;
use App\Models\Concerns\CommentTrait;
use App\Models\Concerns\BoostTrait;
use App\Models\Concerns\ArchiveTrait;
use App\Models\Category;
use App\Builders\MessageBoardBuilder;

class MessageBoard extends Model implements BucketContract, CommentContract, BoostContract, MoveContract, ArchiveContract
{
    use HasTrixRichText;
    use HasStates;
    use CommentTrait;
    use BoostTrait;
    use MoveTrait;
    use MetaTrait;
    use HasStates;
    use ArchiveTrait;
    use SoftDeletes;
    use StatusTrait;
    use Subscribable;


    protected $guarded = [];

    protected $touches = ['trixRichText'];

    protected $with = ['project'];

    protected function registerStates(): void
    {
        $this->registerStatus();
        $this->addState('state', MessageBoardState::class)
            ->default(Published::class)
            ->allowTransition(Draft::class, Published::class, DraftToPublished::class);
    }

    public static function query(): MessageBoardBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query)
    {
        return new MessageBoardBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function path(): string
    {
        return route('messageBoards.show', [
            'account' => $this->project->account_id,
            'project' => $this->project_id,
            'messageBoard' => $this->id
        ]);
    }

    public function indexPath(): string
    {
        return route('messageBoards.index', [
            'account' => $this->project->account_id,
            'project' => $this->project_id,
        ]);
    }

    public function displayName(): string
    {
        return 'Message Board';
    }

    public function displayField(): string
    {
        return $this->title;
    }

    public function previewCard(): array
    {
        $modelPresenter = getModelPresenter($this);
        return $modelPresenter::make($this->load(['user.media', 'trixRichText']))->preset('previewCard')->get();
    }
}
