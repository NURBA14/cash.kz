<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IncomeCategory\IncomeCategoryStoreRequest;
use App\Http\Requests\Api\V1\IncomeCategory\IncomeCategoryUpdateRequest;
use App\Http\Resources\Api\V1\IncomeCategory\IncomeCategoryIndexResource;
use App\Http\Resources\Api\V1\IncomeCategory\IncomeCategoryShowRecource;
use App\Models\Income_Category;
use Illuminate\Http\Request;

class IncomeCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth:sanctum"])->only(["store", "update", "destroy"]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(["income_categories" => IncomeCategoryIndexResource::collection(Income_Category::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeCategoryStoreRequest $request)
    {
        $income_category = Income_Category::create([
            "name" => $request->validated("name"),
            "description" => $request->validated("description")
        ]);
        return response()->json(["income_category" => new IncomeCategoryShowRecource($income_category)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Income_Category $income_category)
    {
        return response()->json(["income_category" => new IncomeCategoryShowRecource($income_category)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomeCategoryUpdateRequest $request, Income_Category $income_category)
    {
        $income_category->update([
            "name" => $request->validated("name"),
            "description" => $request->validated("description")
        ]);
        return response()->json(["income_category" => new IncomeCategoryShowRecource($income_category)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income_Category $income_category)
    {
        if($income_category->incomes()->count()){
            return response()->json(["message" => "This category has incomes"], 200);
        }
        $income_category->delete();
        return response()->json(["message" => "success"], 200);
    }
}
