<?php

namespace Tests\Feature\Api\V1\Saving;

use App\Models\Saving_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SavingCreateUpdateDeleteTest extends TestCase
{
    protected static $saving;
    protected static $saving_category;
    protected static $user;
    protected static $token;


    public function setUp(): void
    {
        parent::setUp();
        self::$saving_category = Saving_Category::factory()->createOne();
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
    public function test_saving_create(): void
    {
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->post('/api/v1/savings', [
                    "sum" => 1000,
                    "comment" => "com",
                    "saving_category_id" => self::$saving_category->id
                ]);
        $response->assertJsonStructure([
            "saving" => [
                "id",
                "sum",
                "comment",
                "saving_category",
                "user" => [
                    "id",
                    "login"
                ],
                "date"
            ]
        ]);
        self::$saving = $response->json("saving");
        $response->assertStatus(201);
    }

    public function test_saving_update(): void
    {
        $id = self::$saving["id"];
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->put("/api/v1/savings/{$id}", [
                    "sum" => 999,
                    "comment" => "new",
                    "saving_category_id" => self::$saving_category->id
                ]);
        self::$saving = $response->json("saving");
        $response->assertJsonStructure([
            "saving" => [
                "id",
                "sum",
                "comment",
                "saving_category",
                "user" => [
                    "id",
                    "login"
                ],
                "date"
            ]
        ]);
        $response->assertOk();
    }

    public function test_saving_delete()
    {
        $id = self::$saving["id"];
        $response = $this->withHeaders([
            "Authorization" => "Bearer " . self::$token
        ])->delete("/api/v1/savings/{$id}");
        $response->assertJsonStructure([
            "message"
        ]);
        $response->assertOk();
    }
}
