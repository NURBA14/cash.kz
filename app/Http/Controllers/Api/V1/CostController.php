<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Cost\CostStoreRequest;
use App\Http\Requests\Api\V1\Cost\CostUpdateRequest;
use App\Http\Resources\Api\V1\Cost\CostIndexResource;
use App\Http\Resources\Api\V1\Cost\CostShowResource;
use App\Models\Cost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CostController extends Controller
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
        return response()->json(["costs" => CostIndexResource::collection(Cost::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CostStoreRequest $request)
    {
        $cost = Auth::user()->costs()->create([
            "sum" => $request->validated("sum"),
            "comment" => $request->validated("comment"),
            "cost_category_id" => $request->validated("cost_category_id")
        ]);
        return response()->json(["cost" => new CostShowResource($cost)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cost $cost)
    {
        return response()->json(["cost" => new CostShowResource($cost)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CostUpdateRequest $request, Cost $cost)
    {
        $cost->update([
            "sum" => $request->validated("sum"),
            "comment" => $request->validated("comment"),
            "cost_category_id" => $request->validated("cost_category_id")
        ]);
        return response()->json(["cost" => new CostShowResource($cost)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cost $cost)
    {
        $cost->delete();
        return response()->json(["message" => "success"], 200);
    }
}
