<?php

namespace Tests\Feature\Api\V1\Income;

use App\Models\Income_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeCreateUpdateDeleteTest extends TestCase
{
    protected static $income;
    protected static $income_category;
    protected static $user;
    protected static $token;


    public function setUp(): void
    {
        parent::setUp();
        self::$income_category = Income_Category::factory()->createOne();
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
    public function test_income_create(): void
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->post('/api/v1/incomes', [
            "sum" => 1000,
            "comment" => "com",
            "income_category_id" => self::$income_category->id
        ]);
        $response->assertJsonStructure([
            "income" => [
                "id",
                "sum",
                "comment",
                "income_category",
                "user" => [
                    "id",
                    "login"
                ],
                "date"
            ]
        ]);
        self::$income = $response->json("income");
        $response->assertStatus(201);
    }

    public function test_income_update(): void
    {
        $id = self::$income["id"];
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->put("/api/v1/incomes/{$id}", [
            "sum" => 999,
            "comment" => "new",
            "income_category_id" => self::$income_category->id
        ]);
        self::$income = $response->json("income");
        $response->assertJsonStructure([
            "income" => [
                "id",
                "sum",
                "comment",
                "income_category",
                "user" => [
                    "id",
                    "login"
                ],
                "date"
            ]
        ]);
        $response->assertOk();
    }

    public function test_income_delete()
    {
        $id = self::$income["id"];
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->delete("/api/v1/incomes/{$id}");
        $response->assertJsonStructure([
            "message"
        ]);
        $response->assertOk();
    }
}
