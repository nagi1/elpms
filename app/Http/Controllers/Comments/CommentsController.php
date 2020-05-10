<?php

namespace App\Http\Controllers\Comments;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Comment\UpdateCommentAction;
use App\Actions\Comment\DeleteCommentAction;
use App\Actions\Comment\AddCommentAction;

class CommentsController extends Controller
{
    public function store(Account $account, Project $project, Request $request, AddCommentAction $addCommentAction)
    {
        $addCommentAction->execute($request->validate([
            'comment-trixFields' => ['required'],
            'attachment-comment-trixFields' => ['sometimes']
        ]), getModelByType($request->model, $request->modelId));

        return redirect()->back();
    }

    public function update(Account $account, Project $project, Comment $comment, Request $request, UpdateCommentAction $updateCommentAction)
    {
        $updateCommentAction->execute($comment, $request->validate([
            'comment-trixFields' => ['required'],
            'attachment-comment-trixFields' => ['sometimes']
        ]));

        return redirect()->back();
    }

    public function delete(Account $account, Project $project, Comment $comment, Request $request, DeleteCommentAction $deleteCommentAction)
    {
        $deleteCommentAction->execute($comment, getModelByType($request->model, $request->modelId));
        return redirect()->back();
    }
}
