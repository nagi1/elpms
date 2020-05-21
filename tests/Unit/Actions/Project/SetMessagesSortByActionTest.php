<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;
use App\Actions\Project\SetMessagesSortByAction;

class SetMessagesSortByActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_set_created_at_as_messageBoard_sortBy_default_meta_on_a_project()
    {
        $project = factory(Project::class)->create();
        app(SetMessagesSortByAction::class)->execute($project);
        $this->assertEquals(['sortBy' => 'created_at'], $project->fresh()->meta->messageBoard);
    }
}
