<?php

namespace Tests\Feature\Api\V1\Cost;

use App\Models\Cost_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CostCreateUpdateDeleteTest extends TestCase
{

    protected static $cost;
    protected static $cost_category;
    protected static $user;
    protected static $token;


    public function setUp(): void
    {
        parent::setUp();
        self::$cost_category = Cost_Category::factory()->createOne();
        self::$user = User::factory()->create();
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
    public function test_cost_create(): void
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->post('/api/v1/costs', [
            "sum" => 1000,
            "comment" => "com",
            "cost_category_id" => self::$cost_category->id
        ]);
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
        self::$cost = $response->json("cost");
        $response->assertStatus(201);
    }

    public function test_cost_update(): void
    {
        $id = self::$cost["id"];
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->put("/api/v1/costs/{$id}", [
            "sum" => 999,
            "comment" => "new",
            "cost_category_id" => self::$cost_category->id
        ]);
        self::$cost = $response->json("cost");
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
        $response->assertOk();
    }

    public function test_cost_delete()
    {
        $id = self::$cost["id"];
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->delete("/api/v1/costs/{$id}");
        $response->assertJsonStructure([
            "message"
        ]);
        $response->assertOk();
    }
}
