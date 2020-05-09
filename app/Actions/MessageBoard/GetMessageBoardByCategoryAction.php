<?php

namespace App\Actions\MessageBoard;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Project;

class GetMessageBoardByCategoryAction
{
    private Project $project;
    private $categoryId;

    public function __construct(Project $project, string $categoryId = null)
    {
        $this->project = $project;
        $this->categoryId = $categoryId;
    }

    public function execute(): Collection
    {
        if (empty($this->categoryId)) {
            return $this->query()->get();
        }

        return $this->query()->whereCategory($this->categoryId)->get();
    }

    private function query()
    {
        return $this->project->messageBoards()->with(['user.media', 'trixRichText', 'category'])->withoutArchived()->SortBy($this->project->meta->get('messageBoard.sortBy'))->published()->limit(15);
    }
}
