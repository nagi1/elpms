<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;

class CreateProjectActionTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function it_creates_an_account()
    {
        app(CreateAccountAction::class)->execute([
            'name' => 'Test Account'
        ]);

        $this->assertDatabaseHas('accounts', [
            'name' => 'Test Account'
        ]);
    }

    /** @test */
    public function it_create_account_and_associate_default_categories_to_it()
    {
        $defaultCategories = [
            new Category(['icon' => '😎', 'name' => 'test category 1']),
            new Category(['icon' => '😀', 'name' => 'test category 2']),
        ];
        app(CreateAccountAction::class)->execute([
            'id' => 1,
            'name' => 'Test Account'
        ], $defaultCategories);

        $this->assertDatabaseHas('categories', [
            'account_id' => 1,
            'icon' => '😎',
            'name' => 'test category 1'
        ]);

        $this->assertDatabaseHas('categories', [
            'account_id' => 1,
            'icon' => '😀',
            'name' => 'test category 2'
        ]);
    }
}
