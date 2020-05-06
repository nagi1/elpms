<?php

namespace App\Actions\Comment;

use Auth;
use App\User;
use App\Models\Concerns\Commentable;
use App\Models\Comment;

class DeleteCommentAction
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(Comment $comment, Commentable $model, ?User $user = null): void
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $comment->delete();
        $model->updateCommentCountMeta();
    }
}
