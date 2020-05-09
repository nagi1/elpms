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
            'avatar150' => $this->lazy($this->getFirstMediaUrl('avatar', 'size-150')),
            'avatar' => $this->lazy($this->getFirstMediaUrl('avatar')),
            'company' => $this->company,
            'title' => $this->title,
        ];
    }

    public function presetAvatar()
    {
        return $this->only('avatar', 'avatar64', 'avatar150');
    }

    public function presetAvatarWithData()
    {
        return $this->only('id', 'name', 'avatar', 'avatar64', 'avatar150', 'company', 'title');
    }
}
