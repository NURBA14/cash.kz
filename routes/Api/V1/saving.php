<?php

use App\Http\Controllers\Api\V1\SavingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    "savings" => SavingController::class,
]);
