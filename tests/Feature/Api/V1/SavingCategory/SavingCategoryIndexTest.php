<?php

namespace Tests\Feature\Api\V1\SavingCategory;

use App\Models\Saving;
use App\Models\Saving_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SavingCategoryIndexTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Saving_Category::factory(5)->create();
        Saving::factory(10)->for(User::factory())->create();
    }
    /**
     * A basic feature test example.
     */
    public function test_saving_category_index(): void
    {
        $response = $this->get('/api/v1/saving_categories');
        $response->assertJsonStructure([
            "saving_categories" => [
                "*" => [
                    "id",
                    "name",
                    "description",
                    "savings_count",
                    "created_at"
                ]
            ]
        ]);
        $response->assertOk();
    }
}
