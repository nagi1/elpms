<?php

namespace App\Presenters;

use App\Presenters\UsersPresenter;
use App\Presenters\BoostsPresenter;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class ChangeEventPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'id' => $this->id,
            'createdAt' => shortDate($this->created_at),
            'user' => $this->lazy(UsersPresenter::make($this->whenLoaded('user'))->preset('avatarWithData')),
            'content' => $this->content,
            'type' => $this->type,
            'boosts' => $this->lazy(BoostsPresenter::collection($this->whenLoaded('boosts'))),
        ];
    }
}
