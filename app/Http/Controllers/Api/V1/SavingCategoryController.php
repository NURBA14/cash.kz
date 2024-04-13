<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SavingCategory\SavingCategoryStoreRequest;
use App\Http\Requests\Api\V1\SavingCategory\SavingCategoryUpdateRequest;
use App\Http\Resources\Api\V1\SavingCategory\SavingCategoryIndexResource;
use App\Http\Resources\Api\V1\SavingCategory\SavingCategoryShowResource;
use App\Models\Saving_Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingCategoryController extends Controller
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
        return response()->json(["saving_categories" => SavingCategoryIndexResource::collection(Saving_Category::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavingCategoryStoreRequest $request)
    {
        $saving_category = Saving_Category::create([
            "name" => $request->validated("name"),
            "description" => $request->validated("description"),
        ]);
        return response()->json(["saving_category" => new SavingCategoryShowResource($saving_category)], 201);   
    }

    /**
     * Display the specified resource.
     */
    public function show(Saving_Category $saving_category)
    {
        return response()->json(["saving_category" => new SavingCategoryShowResource($saving_category)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavingCategoryUpdateRequest $request, Saving_Category $saving_category)
    {
        $saving_category->update([
            "name" => $request->validated("name"),
            "description" => $request->validated("description")
        ]);
        return response()->json(["saving_category" => new SavingCategoryShowResource($saving_category)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saving_Category $saving_category)
    {
        if($saving_category->savings()->count()){
            return response()->json(["message" => "This category has Savings"], 200);
        }
        $saving_category->delete();
        return response()->json(["message" => "success"], 200);
    }
}
