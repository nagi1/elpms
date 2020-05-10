<?php

namespace App\Actions\Comment;

use Auth;
use App\User;
use App\Models\Contracts\CommentContract;
use App\Models\Comment;

class DeleteCommentAction
{

    public function execute(Comment $comment, CommentContract $model, ?User $user = null): void
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $comment->delete();
        $model->updateCommentCountMeta();
    }
}
