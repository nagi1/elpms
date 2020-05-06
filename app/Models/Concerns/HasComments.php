<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Auth;
use App\User;
use App\Models\Concerns\HasMeta;
use App\Models\Comment;

trait HasComments
{
    use HasMeta;

    public function getCommentsCount(): int
    {
        return $this->comments()->count();
    }

    public function updateCommentCountMeta(): void
    {
        $this->meta->set([
            'comments_count' => $this->getCommentsCount(),
        ]);
        $this->save();
    }


    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function commentAsUser(User $user, array $attributes): Comment
    {
        $comment = $this->comments()->save(new Comment(array_merge([
            'user_id' => $user->id,
            'commentable_id' => $this->getKey(),
            'commentable_type' => get_class(),
        ], $attributes)));

        $this->updateCommentCountMeta();
        return $comment;
    }
}
