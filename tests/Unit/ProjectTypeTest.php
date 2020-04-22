<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Team;
use App\Project;
use App\HQ;

class ProjectTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_have_hq_type()
    {
        $hq = HQ::create([
            'name' => 'test HQ'
        ]);

        $this->assertInstanceOf(HQ::class, $hq);
    }

    /** @test */
    public function can_have_project_type()
    {
        $project = Project::create([
            'name' => 'test project'
        ]);

        $this->assertInstanceOf(Project::class, $project);
    }

    /** @test */
    public function can_have_team_type()
    {
        $team = Team::create([
            'name' => 'test project'
        ]);

        $this->assertInstanceOf(Team::class, $team);
    }
}
