<?php

namespace App\Presenters;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Presenters\CommentsPresenter;
use App\Presenters\BoostsPresenter;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class MessageBoardsPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->lazy(CategoriesPresenter::make($this->whenLoaded('category'))->only('id', 'fullName')),
            'shortDate' => $this->shortDate($this->created_at),
            'user' => $this->lazy(UsersPresenter::make($this->whenLoaded('user'))->preset('avatarWithData')),
            'trixRichText' => $this->lazy($this->trixRichText->first()->content),
            'excerpt' => $this->lazy($this->excerpt()),
            'cardExcerpt' => $this->lazy($this->excerpt(30)),
            'updated_at' => $this->lazy($this->shortDate($this->updated_at)),
            'archived' => $this->shortDate($this->archived_at),
            'comments' => $this->lazy(CommentsPresenter::collection($this->whenLoaded('comments'))),
            'commentsCount' => $this->lazy($this->meta->get('comments_count')),
            'boosts' => $this->lazy(BoostsPresenter::collection($this->whenLoaded('boosts'))),
        ];
    }

    private function shortDate(?Carbon $date = null): string
    {
        if (is_null($date)) {
            return '';
        }

        if ($date->isToday()) {
            return $date->diffForHumans();
        }

        return $date->format('M j, g:ia');
    }

    private function excerpt($limit = 100): string
    {
        return Str::limit(strip_tags($this->trixRichText->first()->content), $limit, '');
    }

    public function presetCard()
    {
        return $this->only('id', 'title', 'user', 'cardExcerpt', 'category');
    }

    public function presetEdit()
    {
        return $this->only('id', 'title', 'category');
    }

    public function presetIndex()
    {
        return $this->except('cardExcerpt', 'trixRichText');
    }
}
