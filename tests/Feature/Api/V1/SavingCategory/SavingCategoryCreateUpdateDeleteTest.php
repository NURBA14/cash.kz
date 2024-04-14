<?php

namespace Tests\Feature\Api\V1\SavingCategory;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SavingCategoryCreateUpdateDeleteTest extends TestCase
{
    protected static $user;
    protected static $token;
    protected static $saving_category;

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
    public function test_saving_category_create(): void
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->post('/api/v1/saving_categories', [
            "name" => "name",
            "description" => "des",
        ]);
        $response->assertJsonStructure([
            "saving_category" => [
                "id",
                "name",
                "description",
                "created_at",
                "savings_count",
                "savings"
            ]
        ]);
        self::$saving_category = $response->json("saving_category");
        $response->assertStatus(201);
    }

    public function test_saving_category_update()
    {
        $id = self::$saving_category["id"];
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->put("/api/v1/saving_categories/{$id}", [
            "name" => "new name",
            "description" => "new des",
        ]);
        $response->assertJsonStructure([
            "saving_category" => [
                "id",
                "name",
                "description",
                "created_at",
                "savings_count",
                "savings"
            ]
        ]);
        self::$saving_category = $response->json("saving_category");
        $response->assertOk();
    }

    public function test_saving_category_delete()
    {
        $id = self::$saving_category["id"];
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->delete("/api/v1/saving_categories/{$id}");
        $response->assertJsonStructure([
            "message"
        ]);
        $response->assertOk();
    }
}
