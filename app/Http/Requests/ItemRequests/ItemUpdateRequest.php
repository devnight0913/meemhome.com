<?php

namespace App\Http\Requests\ItemRequests;

use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
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
            'description' => ['nullable', 'string'],

            'price' => ['required', 'numeric', 'min:0'],

            'discount' => ['required', 'numeric', 'between:0,100'],

            'cost' => ['required', 'numeric', 'min:0'],

            'in_stock' => ['required', 'integer', 'min:0'],
            'warranty_period' => ['nullable', 'integer', 'min:0'],
            'barcode' => ['nullable', 'string', 'max:43', 'unique:items,barcode,' . $this->item->id],
            'sku' => ['nullable', 'string', 'max:64', 'unique:items,sku,' . $this->item->id],
            'code' => ['nullable', 'string', 'max:190', 'unique:items,code,' . $this->item->id],

            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'keywords' => ['nullable', 'string', 'max:160'],

            'image' => ['nullable', 'max:2024'],
            'category' => ['required', 'string'],
            'status' => ['required', 'integer'],

        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
