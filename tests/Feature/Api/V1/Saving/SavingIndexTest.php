<?php

namespace Tests\Feature\Api\V1\Saving;

use App\Models\Saving;
use App\Models\Saving_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SavingIndexTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $saving_category = Saving_Category::factory()->createOne();
        Saving::factory(10)->for(User::factory())->create([
            "saving_category_id" => $saving_category->id
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_saving_index(): void
    {
        $response = $this->get("/api/v1/savings");
        $response->assertJsonStructure([
            "savings" => [
                "*" => [
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
            ]
        ]);
        $response->assertOk();
    }
}
