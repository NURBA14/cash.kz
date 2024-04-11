<?php

namespace Database\Seeders;

use App\Models\Cost;
use App\Models\Cost_Category;
use App\Models\Income;
use App\Models\Income_Category;
use App\Models\Saving;
use App\Models\Saving_Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Saving_Category::factory(5)->create();
        Income_Category::factory(5)->create();
        Cost_Category::factory(5)->create();
        Saving::factory(10)->create();
        Income::factory(10)->create();
        Cost::factory(10)->create();
        
    }
}
