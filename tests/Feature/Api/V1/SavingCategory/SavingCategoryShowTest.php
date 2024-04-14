<?php

namespace Tests\Feature\Api\V1\SavingCategory;

use App\Models\Saving;
use App\Models\Saving_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SavingCategoryShowTest extends TestCase
{
    use RefreshDatabase;

    protected static $saving_category;
    public function setUp(): void
    {
        parent::setUp();
        self::$saving_category = Saving_Category::factory()->createOne();
        Saving::factory(3)->for(User::factory())->create([
            "saving_category_id" => self::$saving_category->id
        ]);
    }

    public static function savingsList()
    {
        return self::$saving_category->savings->map(fn($saving) => [
            "id" => $saving->id,
            "sum" => $saving->sum,
            "comment" => $saving->comment,
            "user" => [
                "id" => $saving->user->id,
                "login" => $saving->user->login
            ],
            "date" => $saving->created_at
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_saving_category_show(): void
    {
        $id = self::$saving_category->id;
        $response = $this->get("/api/v1/saving_categories/{$id}");
        $response->assertJsonStructure([
            "saving_category" => [
                "id",
                "name",
                "description",
                "created_at",
                "savings_count",
                "savings" => [
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
            "saving_category" => [
                "id" => self::$saving_category->id,
                "name" => self::$saving_category->name,
                "description" => self::$saving_category->description,
                "created_at" => self::$saving_category->created_at,
                "savings_count" => self::$saving_category->savings()->count(),
                "savings" => self::savingsList()->toArray()
            ]
        ]);
        $response->assertOk();
    }
}
