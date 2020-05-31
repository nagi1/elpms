<?php

namespace App\Presenters;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Presenters\Contracts\PreviewContract;
use App\Presenters\CommentsPresenter;
use App\Presenters\BoostsPresenter;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class MessageBoardsPresenter extends FlexiblePresenter implements PreviewContract
{
    public function values(): array
    {
        return [
            'modelName' => 'MessageBoard',
            'modelDisplayName' => $this->displayName(),
            'path' => fn () => $this->path(),
            'id' => $this->id,
            'title' => $this->title,
            'category' => fn () => CategoriesPresenter::make($this->whenLoaded('category'))->only('id', 'fullName'),
            'shortDate' => shortDate($this->created_at),
            'user' => fn () => UsersPresenter::make($this->whenLoaded('user'))->preset('avatarWithData'),
            'trixRichText' => fn () => $this->content,
            'excerpt' => fn () => $this->excerpt(),
            'cardExcerpt' => fn () => $this->excerpt(30),
            'updated_at' => fn () => shortDate($this->updated_at),
            'archived' => shortDate($this->archived_at),
            'comments' => fn () => CommentsPresenter::collection($this->whenLoaded('comments')),
            'commentsCount' => fn () => $this->meta->get('comments_count'),
            'boosts' => fn () => BoostsPresenter::collection($this->whenLoaded('boosts')),
            'subscribers' => fn () => UsersPresenter::make($this->whenLoaded('subscribers'))->preset('avatarWithData'),
            'trashedAtDate' => fn () => $this->deleted_at,
            'trashed' => fn () => shortDate($this->deleted_at),
        ];
    }

    private function excerpt($limit = 100): string
    {
        return Str::limit(strip_tags($this->content), $limit, '');
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
        return $this->except('cardExcerpt', 'trixRichText', 'comments');
    }

    public function presetPreviewCard()
    {
        return $this->only('id', 'title', 'cardExcerpt', 'user', 'modelName', 'modelDisplayName', 'path', 'trashed', 'trashedAtDate');
    }

    public function presetSubscribers()
    {
        return $this->only('subscribers');
    }
}
