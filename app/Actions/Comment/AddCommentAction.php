<?php

namespace App\Actions\Comment;

use Auth;
use App\User;

use App\Models\Contracts\CommentContract;
use App\Models\Comment;

class AddCommentAction
{

    public function execute(array $attributes, CommentContract $model, ?User $user = null): Comment
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        return $model->commentAsUser($user, $attributes);
    }
}
