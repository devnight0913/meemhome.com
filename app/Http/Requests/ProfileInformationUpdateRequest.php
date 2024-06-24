<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileInformationUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:70'],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($this->user()->id)],
            'phone' => ['nullable',  'max:25', Rule::unique('users')->ignore($this->user()->id)],

            'photo' => ['nullable', 'image', 'max:1024'],
            'birthday' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:150'],


            'contact_email' => ['nullable', 'email', 'max:100'],
            'contact_phone' => ['nullable',  'max:25'],

            'area' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:190'],


        ];
    }
}
