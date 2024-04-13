<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CostCategory\CostCategoryStoreRequest;
use App\Http\Resources\Api\V1\CostCategory\CostCategoryIndecResource;
use App\Http\Resources\Api\V1\CostCategory\CostCategoryShowResource;
use App\Models\Cost_Category;
use Illuminate\Http\Request;

class CostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(["cost_categories" => CostCategoryIndecResource::collection(Cost_Category::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CostCategoryStoreRequest $request)
    {
        $cost_category = Cost_Category::create([
            "name" => $request->validated("name"),
            "description" => $request->validated("description"),
        ]);
        return response()->json(["cost_category" => new CostCategoryShowResource($cost_category)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cost_Category $cost_category)
    {
        return response()->json(["cost_category" => new CostCategoryShowResource($cost_category)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
