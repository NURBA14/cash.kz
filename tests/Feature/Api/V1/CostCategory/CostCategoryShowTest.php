<?php

namespace Tests\Feature\Api\V1\CostCategory;

use App\Models\Cost;
use App\Models\Cost_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CostCategoryShowTest extends TestCase
{
    use RefreshDatabase;
    protected static $cost_category;
    public function setUp(): void
    {
        parent::setUp();
        self::$cost_category = Cost_Category::factory()->createOne();
        Cost::factory(3)->for(User::factory())->create([
            "cost_category_id" => self::$cost_category->id
        ]);
    }

    public static function costsList()
    {
        return self::$cost_category->costs->map(fn($cost) => [
            "id" => $cost->id,
            "sum" => $cost->sum,
            "comment" => $cost->comment,
            "user" => [
                "id" => $cost->user->id,
                "login" => $cost->user->login
            ],
            "date" => $cost->created_at
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_cost_category_show(): void
    {
        $id = self::$cost_category->id;
        $response = $this->get("/api/v1/cost_categories/{$id}");
        $response->assertJsonStructure([
            "cost_category" => [
                "id",
                "name",
                "description",
                "created_at",
                "costs_count",
                "costs" => [
                    "*" => [
                        "id",
                        "sum",
                        "comment",
                        "user" => [
                            "id",
                            "login"
                        ],
                        "date"
                    ]
                ]
            ]
        ]);
        $response->assertJson([
            "cost_category" => [
                "id" => self::$cost_category->id,
                "name" => self::$cost_category->name,
                "description" => self::$cost_category->description,
                "created_at" => self::$cost_category->created_at,
                "costs_count" => self::$cost_category->costs()->count(),
                "costs" => self::costsList()->toArray()
            ]
        ]);
        $response->assertOk();
    }
}
