<?php

use App\Http\Controllers\Api\V1\CostCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    "cost_categories" => CostCategoryController::class
]);