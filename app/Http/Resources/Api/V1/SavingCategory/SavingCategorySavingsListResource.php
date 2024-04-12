<?php

namespace App\Http\Resources\Api\V1\SavingCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SavingCategorySavingsListResource extends JsonResource
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
            "user" => [
                "id" => $this->user->id,
                "name" => $this->user->login,
            ],
            "date" => $this->created_at
        ];
    }
}
