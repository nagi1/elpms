<?php

namespace App\Actions\Project;

use App\Models\Project;
use App\Actions\AddCategoriesTo;

class AddCategoriesToProjectAction extends AddCategoriesTo
{
    private Project $project;
    private array $categories;

    public function __construct(Project $project, array $categories)
    {
        $this->project = $project;
        $this->categories = $this->normalizeCategories($categories);
    }

    public function execute(): void
    {
        $this->project->categories()->saveMany($this->categories);
    }
}
