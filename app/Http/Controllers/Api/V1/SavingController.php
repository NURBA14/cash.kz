<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Saving\SavingStoreRequest;
use App\Http\Requests\Api\V1\Saving\SavingUpdateRequest;
use App\Http\Resources\Api\V1\Saving\SavingIndexResource;
use App\Http\Resources\Api\V1\Saving\SavingShowResource;
use App\Models\Saving;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingController extends Controller
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
        return response()->json(["savings" => SavingIndexResource::collection(Saving::all())], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavingStoreRequest $request)
    {
        $saving = Auth::user()->savings()->create([
            "sum" => $request->validated("sum"),
            "comment" => $request->validated("comment"),
            "saving_category_id" => $request->validated("saving_category_id"),
        ]);
        return response()->json(["saving" => new SavingShowResource($saving)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Saving $saving)
    {
        return response()->json(["saving" => new SavingShowResource($saving)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavingUpdateRequest $request, Saving $saving)
    {
        $saving->update([
            "sum" => $request->validated("sum"),
            "comment" => $request->validated("comment"),
            "saving_category_id" => $request->validated("saving_category_id")
        ]);
        return response()->json(["saving" => new SavingShowResource($saving)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saving $saving)
    {
        $saving->delete();
        return response()->json(["message" => "success"], 200);
    }
}
