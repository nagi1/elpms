<?php

namespace App\Models;

use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Spatie\ModelStates\HasStates;
use Overtrue\LaravelSubscribe\Traits\Subscribable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\User;
use App\States\Status\Trashed;
use App\States\Status\Status;
use App\States\Status\Restored;
use App\States\Status\ArchivedToTrashed;
use App\States\Status\Archived;
use App\States\MessageBoard\Published;
use App\States\MessageBoard\MessageBoardState;
use App\States\MessageBoard\DraftToPublished;
use App\States\MessageBoard\Draft;
use App\Models\Project;
use App\Models\Contracts\BucketContract;
use App\Models\Concerns\Moveable;
use App\Models\Concerns\MoveTrait;
use App\Models\Concerns\HasStatus;
use App\Models\Concerns\HasMeta;
use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasBoosts;
use App\Models\Concerns\Commentable;
use App\Models\Concerns\Boostable;
use App\Models\Concerns\Archiveable;
use App\Models\Concerns\ArchiveTrait;
use App\Models\Category;
use App\Builders\MessageBoardBuilder;

class MessageBoard extends Model implements Commentable, Boostable, Moveable, Archiveable, BucketContract
{
    use HasTrixRichText;
    use HasStates;
    use HasComments;
    use HasBoosts;
    use MoveTrait;
    use HasMeta;
    use HasStates;
    use ArchiveTrait;
    use SoftDeletes;
    use HasStatus;
    use Subscribable;



    protected $guarded = [];

    protected $touches = ['trixRichText'];



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
            'account' => $this->load(['project.account'])->project->account,
            'project' => $this->project_id,
            'messageBoard' => $this->id
        ]);
    }

    public function indexPath(): string
    {
        return route('messageBoards.index', [
            'account' => $this->load(['project.account'])->project->account,
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
