<?php

namespace App\Http\Requests\Api\V1\SavingCategory;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class SavingCategoryUpdateRequest extends ApiRequest
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
            "name" => "required|string|max:255",
            "description" => "nullable|string"
        ];
    }
}
