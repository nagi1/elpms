<?php

namespace App\Actions\MessageBoard;

use Auth;
use App\User;
use App\States\Project\Published;
use App\Models\Project;
use App\Models\MessageBoard;

class CreateMessageBoardAction
{
    private array $attributes;
    private Project $project;
    private User $user;

    public function __construct(Project $project, array $attributes, User $user = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $this->attributes = $attributes;
        $this->project = $project;
        $this->user = $user;
        $this->mergeUser();
    }

    public function execute(): MessageBoard
    {
        $messageBoard = $this->project
            ->messageBoards()
            ->save(new MessageBoard($this->attributes));
        return $messageBoard;
    }

    private function mergeUser()
    {
        $this->attributes = array_merge($this->attributes, ['user_id' => $this->user->id]);
    }
}
