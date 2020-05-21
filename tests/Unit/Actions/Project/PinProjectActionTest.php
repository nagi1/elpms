<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;

use App\Actions\Project\PinProjectAction;

class PinProjectActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_pin_project()
    {
        $project = factory(Project::class)->create();
        app(PinProjectAction::class)->execute($project, true);
        $this->assertTrue($project->fresh()->pinned);
    }

    /** @test */
    public function it_can_unpin_project()
    {
        $project = factory(Project::class)->create();
        app(PinProjectAction::class)->execute($project, false);
        $this->assertFalse($project->fresh()->pinned);
    }
}
