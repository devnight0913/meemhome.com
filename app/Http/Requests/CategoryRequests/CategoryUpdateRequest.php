<?php

namespace App\Http\Requests\CategoryRequests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'sort_order' => ['required', 'numeric', 'min:1'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'keywords' => ['nullable', 'string', 'max:160'],
            'image' => ['nullable', 'max:2024'],
            'cover_image' => ['nullable', 'max:2024'],
            'status' => ['required', 'integer'],
            'parent_id' => ['nullable', 'string'],
        ];
    }
}
