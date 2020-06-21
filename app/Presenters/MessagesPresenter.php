<?php

namespace App\Presenters;

use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class MessagesPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'id' => $this->id,
            'user' => UsersPresenter::make($this->whenLoaded('user'))->preset('avatarWithData'),
            'type' => $this->type,
            'message' => fn () => $this->body,
            'createdAt' => $this->created_at,
            'day' => dayFormat($this->created_at)
        ];
    }
}
