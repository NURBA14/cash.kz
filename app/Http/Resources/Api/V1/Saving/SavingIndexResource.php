<?php

namespace App\Http\Resources\Api\V1\Saving;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SavingIndexResource extends JsonResource
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
            "saving_category" => $this->saving_category->name,
            "user" => [
                "id" => $this->user->id,
                "name" => $this->user->login,
            ],
            "date" => $this->created_at
        ];
    }
}
