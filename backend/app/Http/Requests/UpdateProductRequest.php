<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'description' => ['sometimes', 'nullable', 'string'],
            'category_id' => ['sometimes', 'integer', 'min:1'],
            'images' => ['sometimes', 'array', 'min:1'],
            'images.*' => ['required', 'url', 'max:2048'],
        ];
    }
}
