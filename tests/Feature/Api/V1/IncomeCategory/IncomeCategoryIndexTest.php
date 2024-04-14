<?php

namespace Tests\Feature\Api\V1\IncomeCategory;

use App\Models\Income;
use App\Models\Income_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeCategoryIndexTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Income_Category::factory(5)->create();
        Income::factory(10)->for(User::factory())->create();
    }
    /**
     * A basic feature test example.
     */
    public function test_income_category_index(): void
    {
        $response = $this->get('/api/v1/income_categories');
        $response->assertJsonStructure([
            "income_categories" => [
                "*" => [
                    "id",
                    "name",
                    "description",
                    "incomes_count",
                    "created_at"
                ]
            ]
        ]);
        $response->assertOk();
    }
}
