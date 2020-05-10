<?php

namespace Tests\Unit\Models\Concerns;

use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortableTest extends TraitTestCase
{

    use RefreshDatabase;



    /** @test */
    public function model_has_sort_by_meta_attribute_when_it_created()
    {
        $dummy = Dummy::create([
            'name' => 'dummy',
        ]);

        $this->assertNotNull($dummy->meta->sortBy);
    }

    /** @test */
    public function it_sorts_by_created_at_by_default()
    {
        Dummy::create([
            'name' => 'dummy now',
            'created_at' => Carbon::now(),
        ]);

        Dummy::create([
            'name' => 'dummy yesterday',
            'created_at' => Carbon::yesterday(),
        ]);


        $this->assertEquals('dummy now', Dummy::first()->name);
        $this->assertEquals('dummy yesterday', Dummy::find(2)->name);
    }


    /** @test */
    public function it_sorts_by_name_ascending()
    {
        Dummy::create([
            'name' => 'ABC',
        ]);

        Dummy::create([
            'name' => 'DEF',
        ]);

        $dummies =  Dummy::sortBy('name')->get();
        $this->assertEquals('ABC', $dummies[0]->name);
        $this->assertEquals('DEF', $dummies[1]->name);
    }

    /** @test */
    public function it_sorts_by_update_at()
    {
        $dummy = Dummy::create([
            'name' => 'new Dummy A',
        ]);

        Dummy::create([
            'name' => 'new Dummy B',
        ]);

        $dummy->update([
            'name' => 'updated'
        ]);



        $dummies =  Dummy::setSortBy('updated_at')->get();
        $this->assertEquals('ABC', $dummies[0]->name);
        $this->assertEquals('DEF', $dummies[1]->name);
    }
}
