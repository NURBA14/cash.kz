<?php

namespace App\Http\Requests\Api\V1\Income;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class IncomeUpdateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "sum" => "required|integer",
            "comment" => "nullable|string",
            "income_category_id" => "required|integer"
        ];
    }
}
