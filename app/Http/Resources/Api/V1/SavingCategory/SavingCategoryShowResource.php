<?php

namespace App\Http\Resources\Api\V1\SavingCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SavingCategoryShowResource extends JsonResource
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
            "savings_count" => $this->savings->count(),
            "savings" => SavingCategorySavingsListResource::collection($this->savings)
        ];
    }
}
