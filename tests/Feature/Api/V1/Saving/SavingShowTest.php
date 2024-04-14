<?php

namespace Tests\Feature\Api\V1\Saving;

use App\Models\Saving;
use App\Models\Saving_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SavingShowTest extends TestCase
{
    use RefreshDatabase;

    protected static $saving;
    public function setUp(): void
    {
        parent::setUp();
        $saving_category = Saving_Category::factory()->createOne();
        self::$saving = Saving::factory()->for(User::factory())->createOne([
            "saving_category_id" => $saving_category->id
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_saving_show(): void
    {
        $id = self::$saving->id;
        $response = $this->get("/api/v1/savings/{$id}");
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
        $response->assertJson([
            "saving" => [
                "id" => self::$saving->id,
                "sum" => self::$saving->sum,
                "comment" => self::$saving->comment,
                "saving_category" => self::$saving->saving_category->name,
                "user" => [
                    "id" => self::$saving->user->id,
                    "login" => self::$saving->user->login
                ],
                "date" => self::$saving->created_at
            ]
        ]);
        $response->assertOk();
    }
}
