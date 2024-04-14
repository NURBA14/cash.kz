<?php

namespace Tests\Feature\Api\V1\Cost;

use App\Models\Cost;
use App\Models\Cost_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CostIndexTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $cost_category = Cost_Category::factory()->createOne();
        Cost::factory(10)->for(User::factory())->create([
            "cost_category_id" => $cost_category->id
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_cost_index(): void
    {
        $response = $this->get('/api/v1/costs');
        $response->assertJsonStructure([
            "costs" => [
                "*" => [
                    "id",
                    "sum",
                    "comment",
                    "cost_category",
                    "user" => [
                        "id",
                        "login"
                    ],
                    "date"
                ]
            ]
        ]);
        $response->assertOk();
    }
}
