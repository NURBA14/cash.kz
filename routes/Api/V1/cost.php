<?php

use App\Http\Controllers\Api\V1\CostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    "costs" => CostController::class
]);