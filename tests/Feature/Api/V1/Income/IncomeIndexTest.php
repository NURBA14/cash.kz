<?php

namespace Tests\Feature\Api\V1\Income;

use App\Models\Income;
use App\Models\Income_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeIndexTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $income_category = Income_Category::factory()->createOne();
        Income::factory(10)->for(User::factory())->create([
            "income_category_id" => $income_category->id
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_income_index(): void
    {
        $response = $this->get('/api/v1/incomes');
        $response->assertJsonStructure([
            "incomes" => [
                "*" => [
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
            ]
        ]);
        $response->assertOk();
    }
}
