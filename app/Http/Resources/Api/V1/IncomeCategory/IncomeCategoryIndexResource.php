<?php

namespace App\Http\Resources\Api\V1\IncomeCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeCategoryIndexResource extends JsonResource
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
            "incomes_count" => $this->incomes->count(),
            "created_at" => $this->created_at
        ];
    }
}
