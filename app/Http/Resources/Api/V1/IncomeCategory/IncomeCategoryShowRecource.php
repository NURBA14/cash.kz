<?php

namespace App\Http\Resources\Api\V1\IncomeCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeCategoryShowRecource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "created_at" => $this->created_at,
            "incomes_count" => $this->incomes->count(),
            "incomes" => IncomeCategoryIncomesListRecource::collection($this->incomes)
        ];
    }
}
