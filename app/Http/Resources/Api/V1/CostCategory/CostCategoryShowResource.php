<?php

namespace App\Http\Resources\Api\V1\CostCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CostCategoryShowResource extends JsonResource
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
            "savings_count" => $this->costs->count(),
            "savings" => CostCategoryCostsListResource::collection($this->costs)
        ];
    }
}