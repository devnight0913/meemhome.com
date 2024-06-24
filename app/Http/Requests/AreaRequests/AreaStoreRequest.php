<?php

namespace App\Http\Requests\AreaRequests;

use Illuminate\Foundation\Http\FormRequest;

class AreaStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'fee' => ['required', 'numeric', 'min:0'],
            'time' => ['required', 'numeric', 'min:0'],
        ];
    }
}
