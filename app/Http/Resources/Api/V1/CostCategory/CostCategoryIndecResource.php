<?php

namespace App\Http\Resources\Api\V1\CostCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CostCategoryIndecResource extends JsonResource
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
            "costs_count" => $this->costs->count(),
            "created_at" => $this->created_at
        ];
    }
}
