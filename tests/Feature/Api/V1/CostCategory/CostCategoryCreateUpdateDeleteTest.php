<?php

namespace Tests\Feature\Api\V1\CostCategory;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CostCategoryCreateUpdateDeleteTest extends TestCase
{
    protected static $user;
    protected static $token;
    protected static $cost_category;

    public function setUp(): void
    {
        parent::setUp();
        self::$user = User::factory()->createOne();
    }

    public function test_login(): void
    {
        $response = $this->post('/api/v1/login', [
            "login" => self::$user->login,
            "password" => "password",
        ]);
        $response->assertJsonStructure([
            "token"
        ]);
        self::$token = $response->json("token");
        $response->assertOk();
    }
    /**
     * A basic feature test example.
     */
    public function test_cost_category_create(): void
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->post('/api/v1/cost_categories', [
            "name" => "name",
            "description" => "des",
        ]);
        $response->assertJsonStructure([
            "cost_category" => [
                "id",
                "name",
                "description",
                "created_at",
                "costs_count",
                "costs"
            ]
        ]);
        self::$cost_category = $response->json("cost_category");
        $response->assertStatus(201);
    }

    public function test_cost_category_update()
    {
        $id = self::$cost_category["id"];
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->put("/api/v1/cost_categories/{$id}", [
            "name" => "new name",
            "description" => "new des",
        ]);
        $response->assertJsonStructure([
            "cost_category" => [
                "id",
                "name",
                "description",
                "created_at",
                "costs_count",
                "costs"
            ]
        ]);
        self::$cost_category = $response->json("cost_category");
        $response->assertOk();
    }

    public function test_cost_category_delete()
    {
        $id = self::$cost_category["id"];
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->delete("/api/v1/cost_categories/{$id}");
        $response->assertJsonStructure([
            "message"
        ]);
        $response->assertOk();
    }
}
