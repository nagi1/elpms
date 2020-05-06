<?php

namespace App\Presenters;

use App\Presenters\ProjectsPresenter;
use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class CategoriesPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->full_name,
            'name' => $this->name,
            'icon' => $this->icon,
            'project_id' => $this->lazy(ProjectsPresenter::make($this->whenLoaded('project'))->only('id'))
        ];
    }
}
