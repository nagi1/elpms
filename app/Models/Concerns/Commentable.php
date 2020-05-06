<?php

namespace App\Models\Concerns;

use App\User;
use App\Models\Comment;

interface Commentable
{
    public function getCommentsCount(): int;
    public function updateCommentCountMeta(): void;
    public function commentAsUser(User $user, array $attributes): Comment;
}
