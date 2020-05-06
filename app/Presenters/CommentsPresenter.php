<?php

namespace App\Presenters;

use Carbon\Carbon;
use App\Presenters\UsersPresenter;
use App\Presenters\BoostsPresenter;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class CommentsPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'id' => $this->id,
            'trixRichText' => $this->lazy($this->trixRichText->first()->content),
            'user' => $this->lazy(UsersPresenter::make($this->user)->preset('avatarWithData')),
            'date' => $this->shortDate($this->created_at),
            'boosts' => $this->lazy(BoostsPresenter::collection($this->whenLoaded('boosts'))),

        ];
    }

    private function shortDate(Carbon $date): string
    {
        if ($date->isToday()) {
            return $date->diffForHumans();
        }

        return $date->format('M j, g:ia');
    }
}
