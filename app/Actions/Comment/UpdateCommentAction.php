<?php

namespace App\Actions\Comment;

use Auth;
use App\User;
use App\Models\Comment;

class UpdateCommentAction
{
    public function execute(Comment $comment, array $attributes,  ?User $user = null): void
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $comment->update($attributes);
    }
}
