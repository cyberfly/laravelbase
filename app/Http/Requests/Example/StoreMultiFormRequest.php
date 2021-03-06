<?php

namespace App\Http\Requests\Example;

use Illuminate\Foundation\Http\FormRequest;

class StoreMultiFormRequest extends FormRequest
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
            'users' => 'required|array',
            'users.*.name' => 'required',
            'users.*.ic' => 'required|numeric',
            'users.*.email' => 'required|email',
            'users.*.phone' => 'required|numeric',
        ];
    }
}
