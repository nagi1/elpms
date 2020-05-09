<?php

namespace App\Actions\MessageBoard;

use Auth;
use App\User;
use App\Models\Project;
use App\Models\MessageBoard;
use App\Actions\Subscribable\SubscribeProjectSubscribersAction;
use App\Actions\Notification\SubscribeAction;

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
        $this->normalizeAttributes();
    }

    public function execute(): MessageBoard
    {
        $messageBoard = $this->project
            ->messageBoards()
            ->save(new MessageBoard($this->attributes));

        app(SubscribeProjectSubscribersAction::class)->execute($messageBoard);
        return $messageBoard;
    }



    private function mergeUser()
    {
        $this->attributes = array_merge($this->attributes, ['user_id' => $this->user->id]);
    }

    private function normalizeAttributes()
    {
        $this->mergeUser();
        if (empty($this->attributes['title'])) {
            $this->attributes['title'] = 'Untitled';
        }
    }
}