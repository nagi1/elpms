<?php

namespace Tests\Unit\Actions\Project;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;

use App\Actions\Project\AddCategoriesToProjectAction;


class AddCategoriesToProjectActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_add_categories_to_project()
    {
        $project = factory(Project::class)->create();

        $categories = [
            [
                'name' => 'category1',
                'icon' => 'icon1'
            ],
            [
                'name' => 'category2',
                'icon' => 'icon2'
            ],
        ];
        app(AddCategoriesToProjectAction::class)->execute($project, $categories);

        $this->assertCount(2, $project->fresh()->categories);
        $this->assertDatabaseHas('categories', [
            'name' => 'category1',
            'icon' => 'icon1'
        ]);
        $this->assertDatabaseHas('categories', [
            'name' => 'category2',
            'icon' => 'icon2'
        ]);
    }
}
