<?php

namespace App\Http\Resources\Api\V1\Cost;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CostShowResource extends JsonResource
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
            "sum" => $this->sum,
            "comment" => $this->comment,
            "cost_category" => $this->cost_category->name,
            "user" => [
                "id" => $this->user->id,
                "name" => $this->user->login,
            ],
            "date" => $this->created_at
        ];
    }
}
