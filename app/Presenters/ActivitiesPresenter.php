<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class ActivitiesPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->lazy(class_basename($this->subject_type)),
            'action' => $this->getExtraProperty('action'),
            'data' => $this->lazy($this->getExtraProperty('data')),
            'user' => $this->lazy(UsersPresenter::make($this->whenLoaded('causer'))->preset('avatarWithData')),
            'time' => $this->created_at->format('g:ia'),
            'day' => dayFormat($this->created_at),
            'created_at' => $this->created_at,
        ];
    }
}
