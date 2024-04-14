<?php

namespace Tests\Feature\Api\V1\Income;

use App\Models\Income;
use App\Models\Income_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeShowTest extends TestCase
{
    use RefreshDatabase;
    protected static $income;
    public function setUp(): void
    {
        parent::setUp();
        $income_category = Income_Category::factory()->createOne();
        self::$income = Income::factory()->for(User::factory())->createOne([
            "income_category_id" => $income_category->id
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_income_show(): void
    {
        $id = self::$income->id;
        $response = $this->get("/api/v1/incomes/{$id}");
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
        $response->assertJson([
            "income" => [
                "id" => self::$income->id,
                "sum" => self::$income->sum,
                "comment" => self::$income->comment,
                "income_category" => self::$income->income_category->name,
                "user" => [
                    "id" => self::$income->user->id,
                    "login" => self::$income->user->login
                ],
                "date" => self::$income->created_at
            ]
        ]);
        $response->assertOk();
    }
}
