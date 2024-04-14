<?php

namespace Tests\Feature\Api\V1\CostCategory;

use App\Models\Cost;
use App\Models\Cost_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CostCategoryIndexTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Cost_Category::factory(5)->create();
        Cost::factory(10)->for(User::factory())->create();
    }
    /**
     * A basic feature test example.
     */
    public function test_cost_category_index(): void
    {
        $response = $this->get('/api/v1/cost_categories');
        $response->assertJsonStructure([
            "cost_categories" => [
                "*" => [
                    "id",
                    "name",
                    "description",
                    "costs_count",
                    "created_at"
                ]
            ]
        ]);
        $response->assertOk();
    }
}
