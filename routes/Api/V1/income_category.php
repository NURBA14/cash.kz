<?php

use App\Http\Controllers\Api\V1\IncomeCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    "income_categories" => IncomeCategoryController::class
]);