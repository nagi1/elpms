<?php

namespace App\Models\Contracts;

use App\User;
use App\Models\Comment;

interface CommentContract
{
    public function getCommentsCount(): int;
    public function updateCommentCountMeta(): void;
    public function commentAsUser(User $user, array $attributes): Comment;
}
