<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Income\IncomeStoreRequest;
use App\Http\Requests\Api\V1\Income\IncomeUpdateRequest;
use App\Http\Resources\Api\V1\Income\IncomeIndexResource;
use App\Http\Resources\Api\V1\Income\IncomeShowResource;
use App\Models\Income;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(["incomes" => IncomeIndexResource::collection(Income::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeStoreRequest $request)
    {
        // TODO User login
        Auth::login(User::inRandomOrder()->first());
        $income = Auth::user()->incomes()->create([
            "sum" => $request->validated("sum"),
            "comment" => $request->validated("comment"),
            "income_category_id" => $request->validated("income_category_id"),
        ]);
        return response()->json(["income" => new IncomeShowResource($income)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        return response()->json(["income" => new IncomeShowResource($income)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomeUpdateRequest $request, Income $income)
    {
        $income->update([
            "sum" => $request->validated("sum"),
            "comment" => $request->validated("comment"),
            "income_category_id" => $request->validated("income_category_id"),
        ]);
        return response()->json(["income" => new IncomeShowResource($income)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        $income->delete();
        return response()->json(["message" => "success"], 200);
    }
}
