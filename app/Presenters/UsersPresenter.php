<?php

namespace App\Presenters;

use Illuminate\Support\Str;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class UsersPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        [$firstName, $lastName] = array_pad(explode(' ', trim($this->name)), 2, null);
        $lastInitial = empty($lastName) ? '' : mb_substr($lastName, 0, 1) . '.';
        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'lastNameInitial' => $lastInitial,
            'shortName' => "{$firstName}  {$lastInitial}",
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
