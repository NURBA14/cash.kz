<?php

namespace Tests\Feature\Api\V1\Cost;

use App\Models\Cost;
use App\Models\Cost_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CostShowTest extends TestCase
{
    use RefreshDatabase;
    protected static $cost;
    public function setUp(): void
    {
        parent::setUp();
        $cost_category = Cost_Category::factory()->createOne();
        self::$cost = Cost::factory()->for(User::factory())->createOne([
            "cost_category_id" => $cost_category->id
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_cost_show(): void
    {
        $id = self::$cost->id;
        $response = $this->get("/api/v1/costs/{$id}");
        $response->assertJsonStructure([
            "cost" => [
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
        ]);
        $response->assertJson([
            "cost" => [
                "id" => self::$cost->id,
                "sum" => self::$cost->sum,
                "comment" => self::$cost->comment,
                "cost_category" => self::$cost->cost_category->name,
                "user" => [
                    "id" => self::$cost->user->id,
                    "login" => self::$cost->user->login
                ],
                "date" => self::$cost->created_at
            ]
        ]);
        $response->assertOk();
    }
}
