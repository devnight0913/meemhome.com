<?php

namespace App\Http\Requests\CouponRequests;

use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:10', 'unique:coupons'],
            'percentage' => ['required', 'numeric', 'between:0,100'],
            'description' => ['nullable', 'string', 'max:190'],
        ];
    }
}
