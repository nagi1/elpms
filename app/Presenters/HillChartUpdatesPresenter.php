<?php

namespace App\Presenters;

use App\Presenters\UsersPresenter;
use App\Presenters\CommentsPresenter;
use App\Presenters\BoostsPresenter;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class HillChartUpdatesPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'id' => $this->id,
            'data' => $this->lazy(json_decode($this->data, true)),
            'notes' => $this->lazy($this->notes),
            'createdAt' => shortDate($this->created_at),
            'day' => dayFormat($this->created_at),
            'comments' => $this->lazy(CommentsPresenter::collection($this->whenLoaded('comments'))),
            'commentsCount' => $this->lazy($this->meta->get('comments_count')),
            'boosts' => $this->lazy(BoostsPresenter::collection($this->whenLoaded('boosts'))),
            'subscribers' => $this->lazy(UsersPresenter::make($this->whenLoaded('subscribers'))->preset('avatarWithData')),
            'user' => $this->lazy(UsersPresenter::make($this->whenLoaded('user'))->preset('avatarWithData')),

        ];
    }
}
