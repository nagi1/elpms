<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Actions\AddCategoriesTo;


class AddCategoriesToTest extends TestCase
{

    public $mock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = new class extends AddCategoriesTo
        {
            public function addCategory(array $categories): array
            {
                return $this->normalizeCategories($categories);
            }
        };
    }


    /** @test */
    public function it_returns_array_of_categories_when_entering_categories_as_raw_array()
    {
        $rawCategoriesArray = [
            ['name' => 'Test Category name 1', 'icon' => 'icon1'],
            ['name' => 'Test Category name 2', 'icon' => 'icon2'],
        ];

        $returnedCategories = $this->mock->addCategory($rawCategoriesArray);

        $this->assertCount(2, $returnedCategories);
        $this->assertEquals([
            new Category(['name' => 'Test Category name 1', 'icon' => 'icon1']),
            new Category(['name' => 'Test Category name 2', 'icon' => 'icon2']),
        ], $returnedCategories);
    }

    /** @test */
    public function it_returns_array_of_categories_when_providing_array_of_categories()
    {
        $categories = [
            new Category(['name' => 'Test Category name 1', 'icon' => 'icon1']),
            new Category(['name' => 'Test Category name 2', 'icon' => 'icon2']),
        ];

        $returnedCategories = $this->mock->addCategory($categories);

        $this->assertCount(2, $returnedCategories);
        $this->assertEquals([
            new Category(['name' => 'Test Category name 1', 'icon' => 'icon1']),
            new Category(['name' => 'Test Category name 2', 'icon' => 'icon2']),
        ], $returnedCategories);
    }
}
