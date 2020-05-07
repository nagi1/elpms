<?php

namespace App\Models;

use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Spatie\ModelStates\HasStates;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\User;
use App\States\Status\Trashed;
use App\States\Status\StatusState;
use App\States\Status\Restored;
use App\States\Status\ArchivedToTrashed;
use App\States\Status\Archived;
use App\States\MessageBoard\Published;
use App\States\MessageBoard\MessageBoardState;
use App\States\MessageBoard\DraftToPublished;
use App\States\MessageBoard\Draft;
use App\Models\Project;
use App\Models\Concerns\Moveable;
use App\Models\Concerns\HasStatus;
use App\Models\Concerns\HasMeta;
use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasBoosts;
use App\Models\Concerns\Commentable;
use App\Models\Concerns\CanMoved;
use App\Models\Concerns\CanArchived;
use App\Models\Concerns\Boostable;
use App\Models\Concerns\Archiveable;
use App\Models\Category;

class MessageBoard extends Model implements Commentable, Boostable, Moveable, Archiveable
{
    use HasTrixRichText;
    use HasStates;
    use HasComments;
    use HasBoosts;
    use CanMoved;
    use HasMeta;
    use HasStates;
    use CanArchived;
    use SoftDeletes;
    use HasStatus;

    protected $guarded = [];

    protected function registerStates(): void
    {
        $this->registerStatus();

        $this->addState('state', MessageBoardState::class)
            ->default(Draft::class)
            ->allowTransition(Draft::class, Published::class, DraftToPublished::class);
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
        return $this->belongsTo(Category::class);
    }

    public function path()
    {
        return route('messageBoards.show', [
            'account' => $this->load(['project.account'])->project->account,
            'project' => $this->project_id,
            'messageBoard' => $this->id
        ]);
    }

    public function scopePublished($query): Builder
    {
        return $query->whereState('state', Published::class);
    }

    public function scopeDraft($query): Builder
    {
        return $query->whereState('state', Draft::class);
    }

    public function scopeWhereCategory(Builder $query, string $category): Builder
    {
        return $query->where('category_id', $category)->limit(15);
    }

    public function scopeSortBy(Builder $query, string $sortBy): Builder
    {
        if ($sortBy == "date") {
            return $query->orderBy('created_at', 'desc');
        } else if ($sortBy == 'alphabetical') {
            return $query->orderBy('title');
        } else {
            $query->orderBy('id');
        }

        return $query;
    }
}
