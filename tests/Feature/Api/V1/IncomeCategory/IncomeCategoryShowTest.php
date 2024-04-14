<?php

namespace Tests\Feature\Api\V1\IncomeCategory;

use App\Models\Income;
use App\Models\Income_Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeCategoryShowTest extends TestCase
{
    use RefreshDatabase;
    protected static $income_category;
    public function setUp(): void
    {
        parent::setUp();
        self::$income_category = Income_Category::factory()->createOne();
        Income::factory(3)->for(User::factory())->create([
            "income_category_id" => self::$income_category->id
        ]);
    }

    public static function incomesList()
    {
        return self::$income_category->incomes->map(fn($incomes) => [
            "id" => $incomes->id,
            "sum" => $incomes->sum,
            "comment" => $incomes->comment,
            "user" => [
                "id" => $incomes->user->id,
                "login" => $incomes->user->login
            ],
            "date" => $incomes->created_at
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_income_category_show(): void
    {
        $id = self::$income_category->id;
        $response = $this->get("/api/v1/income_categories/{$id}");
        $response->assertJsonStructure([
            "income_category" => [
                "id",
                "name",
                "description",
                "created_at",
                "incomes_count",
                "incomes" => [
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
            "income_category" => [
                "id" => self::$income_category->id,
                "name" => self::$income_category->name,
                "description" => self::$income_category->description,
                "created_at" => self::$income_category->created_at,
                "incomes_count" => self::$income_category->incomes()->count(),
                "incomes" => self::incomesList()->toArray()
            ]
        ]);
        $response->assertOk();
    }
}
