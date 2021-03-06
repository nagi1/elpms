<?php

namespace App\Actions\MessageBoard;

use Auth;
use App\User;
use App\Models\MessageBoard;

class UpdateMessageBoardAction
{
    private array $attributes;
    private MessageBoard $messageBoard;
    private User $user;

    public function __construct(MessageBoard $messageBoard, array $attributes, User $user = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $this->attributes = $attributes;
        $this->messageBoard = $messageBoard;
        $this->user = $user;
        $this->normalizeAttributes();
    }

    public function execute(): bool
    {
        $updated = $this->messageBoard->update($this->attributes);
        $this->messageBoard->touch();
        return $updated;
    }

    private function normalizeAttributes()
    {
        if (empty($this->attributes['title'])) {
            $this->attributes['title'] = 'Untitled';
        }
    }
}
