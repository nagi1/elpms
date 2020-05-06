<?php

namespace App\Presenters;

use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class UsersPresenter extends FlexiblePresenter
{
    public function values(): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar64' => $this->lazy($this->getFirstMediaUrl('avatar', 'size-64')),
            'avatar' => $this->lazy($this->getFirstMediaUrl('avatar')),
        ];
    }

    public function presetAvatar()
    {
        return $this->only('avatar', 'avatar64');
    }

    public function presetAvatarWithData()
    {
        return $this->only('id', 'name', 'avatar', 'avatar64');
    }
}
