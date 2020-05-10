<?php

namespace App\Actions\Project;

use App\Models\Project;
use App\Actions\AbstractActions\AbstractAddCategoriesTo;

class AddCategoriesToProjectAction extends AbstractAddCategoriesTo
{
    public function execute(Project $project, array $categories): void
    {
        $project->categories()->saveMany($this->normalizeCategories($categories));
    }
}
