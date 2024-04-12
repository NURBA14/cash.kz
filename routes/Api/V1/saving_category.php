<?php

use App\Http\Controllers\Api\V1\SavingCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    "saving_categories" => SavingCategoryController::class
]);