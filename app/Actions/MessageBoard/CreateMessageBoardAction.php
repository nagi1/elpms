<?php

namespace App\Actions\MessageBoard;

use Auth;
use App\User;
use App\Presenters\MessageBoardsPresenter;
use App\Models\Project;
use App\Models\MessageBoard;
use App\Actions\Subscription\SubscribeProjectSubscribersAction;


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
        $this->logActivity($messageBoard);

        return $messageBoard;
    }


    private function logActivity($messageBoard)
    {
        activity("project-{$this->project->id}")
            ->performedOn($messageBoard)
            ->causedBy($this->user)
            ->withProperties(['action' => 'CreateMessageBoard', 'data' => MessageBoardsPresenter::make($messageBoard->load(['category']))->only('id', 'title', 'path', 'cardExcerpt', 'category')->get()])
            ->log(':causer.name added a new message called :subject.title');
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
