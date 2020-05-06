<?php

namespace App\Presenters;

use App\Presenters\UsersPresenter;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class BoostsPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'id' => $this->id,
            'content' => $this->lazy($this->content),
            'user' => $this->lazy(UsersPresenter::make($this->user)->preset('avatarWithData')),
        ];
    }
}
